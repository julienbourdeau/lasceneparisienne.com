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
        $this->fb->each(function(GraphEvent $node) use ($ec, $vc) {

            try {
                $venue = Venue::where('id_facebook', $node->getPlace()->getId())->firstOrFail();
            } catch (ModelNotFoundException $e) {
                $venueAttr = $vc->convert($node->getPlace());
                $venue = new Venue($venueAttr);
                $venue->source = $venueAttr;
                $venue->save();
            }

            $eventAttr = $ec->convert($node);

            $event = Event::firstOrNew(['id_facebook' => $node->getId()], $eventAttr);
            $event->forceFill([
                'venue_id' => $venue->id,
                'last_pulled_at' => now(),
                'source' => $eventAttr,

            ]);

            if ($event->id) {
                $this->line("Updated {$event->name} [#{$event->id}]");
            } else {
                $this->info("Added {$event->name}");
            }

            $event->save();

            $ext = File::extension(parse_url($event->meta['cover'])['path']);
            $cover = "/{$event->start_time->year}/{$event->slug}.$ext";
            $finalPath = storage_path('app/public/covers'.$cover);
            if (!File::isDirectory($dir = dirname($finalPath))) {
                File::makeDirectory($dir, 0755, true);
            }

            if (! $this->shouldUpdateCover($event, $finalPath)) {
                return;
            }

            try {
                File::put($tmpPath = storage_path($event->uuid), file_get_contents($event->meta['cover']));
            } catch (\Exception $e) {
                $this->warn($e->getMessage());
                return;
            }

            File::move($tmpPath, $finalPath);

            $event->update(['cover' => $cover]);
        });
    }

    public function shouldUpdateCover($event, $file)
    {
        if (! File::exists($file)) {
            return true;
        }

        if (File::lastModified($file) > now()->subDays(2)->timestamp) {
            return false;
        }

        if ($event->start_time->timestamp < now()->addDays(30)->timestamp) {
            return true;
        }

        return false;
    }
}
