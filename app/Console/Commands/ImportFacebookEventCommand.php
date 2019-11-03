<?php

namespace App\Console\Commands;

use App\Converters\EventConverter;
use App\Facebook\Events;
use App\Facebook\VenueConverter;
use App\Venue;
use Facebook\GraphNodes\GraphEvent;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ImportFacebookEventCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facebook:import';

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
        $facebookIds = \App\Event::get(['id_facebook'])->pluck('id_facebook')->toArray();
        $this->fb->each(function(GraphEvent $node) use ($ec, $vc, $facebookIds) {
            if (in_array($node->getId(), $facebookIds)) {
                $this->line("Skipping {$node->getName()}");
                return;
            }

            $event = $ec->convert($node);

            try {
                $venue = Venue::where('id_facebook', $node->getPlace()->getId())->firstOrFail();
            } catch (ModelNotFoundException $e) {
                $venue = $vc->convert($node->getPlace());
                $venue->save();
            }

            $event->fill([
                'venue_id' => $venue->id,
                'last_pulled_at' => now(),
            ]);

            $event->save();
            $this->info("Saved {$event->name}");
        });
    }
}
