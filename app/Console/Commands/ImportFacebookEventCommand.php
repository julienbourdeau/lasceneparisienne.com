<?php

namespace App\Console\Commands;

use App\Converters\EventConverter;
use App\Event;
use App\Facebook\Events;
use App\Facebook\VenueConverter;
use App\Venue;
use Facebook\GraphNodes\GraphEvent;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;

class ImportFacebookEventCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:facebook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import new Facebook events and skip all existing';

    /**
     * @var Events
     */
    private $fb;

    /**
     * Create a new command instance.
     *
     * @param Events $fb
     */
    public function __construct(Events $fb)
    {
        parent::__construct();
        $this->fb = $fb;
    }

/**
 * Execute the console command.
 *
 * @param EventConverter $ec
 * @param VenueConverter $vc
 * @return mixed
 */
    public function handle(EventConverter $ec, VenueConverter $vc)
    {
        $this->fb->eachUpcoming(function(GraphEvent $node) use ($ec, $vc) {

            try {
                $venue = Venue::where('id_facebook', $node->getPlace()->getId())->firstOrFail();
            } catch (ModelNotFoundException $e) {
                $venueAttr = $vc->convert($node->getPlace());
                $venue = new Venue($venueAttr);
                $venue->source = $venueAttr;
                $venue->save();
            }

            $eventAttr = $ec->convert($node);
            $forceCoverUpdate = false;

            $event = Event::where('id_facebook', $node->getId())->first();

            if (is_null($event)) {
                $event = new Event($eventAttr);

                $this->info("[{$event->start_time->toDateString()}] Adding {$event->name}...");
            } else {
                if ($event->startDateIs($eventAttr['start_time'])) {
                    $forceCoverUpdate = true;
                    $this->warn("Event #{$event->id} has a new date: {$event->start_time->toDateString()}");
                }

                unset($eventAttr['slug']);
                $event->forceFill($eventAttr);

                $this->line("[{$event->start_time->toDateString()}] Updating {$event->name} (#{$event->id})...");
            }

            $event->save();

            try {
                $event->updateCover($forceCoverUpdate);
            } catch (\Exception $e) {
                $this->warn($e->getMessage());
            }
        });
    }
}
