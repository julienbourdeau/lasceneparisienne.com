<?php

namespace App\Console\Commands;

use App\Converters\EventConverter;
use App\Event;
use App\Facebook\Events;
use App\Facebook\VenueConverter;
use App\Support\Facades\Fb;
use App\Venue;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\GraphNodes\GraphEvent;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class ImportFacebookEventCommand extends Command
{
    protected $signature = 'import:facebook {--id=*} {--f|force}';

    protected $description = 'Import new Facebook events and skip all existing';

    private Carbon $pulled_at;

    public function handle()
    {
        $this->pulled_at = now();

        if ($ids = $this->option('id')) {
            foreach($ids as $id) {
                $event = Event::find($id);
                $node = Fb::get($event->id_facebook);
                $this->update($node, true);
                exit(0);
            }
        }

        Fb::eachUpcoming(function(GraphEvent $node) {
            $this->update($node);
        });

        $lastPulledLimit = now()->subHour();
        Event::where('start_time', '>', now()->subMonth())->get()->each(function ($event) use ($lastPulledLimit) {
            if ($event->last_pull_at > $lastPulledLimit) {
                return;
            }
            try {
                $node = Fb::get($event->id_facebook);
                $this->update($node);
            } catch (FacebookResponseException $e) {
                $this->error("[Event #{$event->id}] {$e->getMessage()}");
            }
        });
    }

    public function update(GraphEvent $node, $forceCoverUpdate = false)
    {
        $ec = app(EventConverter::class);
        $vc = app(VenueConverter::class);

        try {
            $venue = Venue::where('id_facebook', $node->getPlace()->getId())->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $venueAttr = $vc->convert($node->getPlace());
            $venue = new Venue($venueAttr);
            $venue->source = $venueAttr;
            $venue->save();
        }

        $eventAttr = $ec->convert($node);

        /** @var Event $event */
        $event = Event::where('id_facebook', $node->getId())->first();

        if (is_null($event)) {
            $event = new Event($eventAttr);

            $this->info("[{$event->start_time->toDateString()}] Adding {$event->name}...");
        } else {
            if (! $event->startDateIs($eventAttr['start_time'])) {
                $forceCoverUpdate = true;
                $this->warn("Event #{$event->id} has a new date: {$event->start_time->toDateString()}");
            }

            unset($eventAttr['slug']);
            $event->forceFill(array_merge(
                $eventAttr, [
                    'venue_id' => $venue->id,
                    'last_pulled_at' => $this->pulled_at,
                ]
            ));

            $this->line("[{$event->start_time->toDateString()}] Updating {$event->name} (#{$event->id})...");
        }

        $event->save();

        try {
            $event->updateCover($forceCoverUpdate || $this->option('force'));
        } catch (\Exception $e) {
            $this->warn($e->getMessage());
        }
    }
}
