<?php

namespace App\Console\Commands;

use App\Event;
use App\Venue;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ImportArchiveCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:archive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import custom archive.json';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $archive = json_decode(\File::get(resource_path('archive.json')), true);

        foreach ($archive as $oldEvent) {
            $exists = Event::where('id_facebook', $oldEvent['id_facebook'])->exists();
            if ($exists) {
                continue;
            }

            $attr = array_only($oldEvent, ['name', 'slug', 'start_time', 'end_time', 'description', 'ticket_url', 'meta', 'id_facebook', 'created_at']);
            $event = new Event($attr);

            try {
                $venue = Venue::where('id_facebook', $oldEvent['venue']['id_facebook'])->firstOrFail();
            } catch (ModelNotFoundException $e) {
                $venue = Venue::create(array_only($oldEvent['venue'], [
                        'name', 'description', 'slug',
                        'city', 'country', 'country_code',
                        'address_formatted', 'phone_formatted', 'email', 'opening_hours',
                        'lat', 'lng',
                        'meta',
                        'id_facebook'
                    ]));
            }

            $event->venue_id = $venue->id;
            $event->save();

            $this->line("Saved {$event->name}");
        }
    }
}
