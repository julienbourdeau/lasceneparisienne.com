<?php

namespace App\Http\Controllers;

use App\Event;
use Spatie\SchemaOrg\Schema;

class EventController extends Controller
{
    public function show($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        return view('events.show', [
            'event' => $event,
            'breadcrumb' => $this->getBreadcrumb($event),
            'schema' => [
                'event' => $event->toSchema(),
            ],
            'title' => $event->name,
            'description' => $event->meta_description,
            'canonical' => $event->canonical_url,
        ]);
    }

    private function getBreadcrumb(Event $event)
    {
        $eventUrl = canonical($event);
        $venueUrl = canonical($event->venue);

        return Schema::breadcrumbList()->itemListElement([
            Schema::listItem()->item(
                Schema::thing()
                    ->setProperty('id', $listUrl = route('events'))
                    ->name('Tous les concerts')
                    ->url($listUrl)
                    ->identifier($listUrl)
            )->position(1),
            Schema::listItem()->item(
                Schema::thing()
                    ->setProperty('id', $venueUrl)
                    ->name($event->venue->name)
                    ->url($venueUrl)
                    ->identifier($venueUrl)
            )->position(2),
            Schema::listItem()->item(
                Schema::thing()
                    ->setProperty('id', $eventUrl)
                    ->name($event->name)
                    ->url($eventUrl)
                    ->identifier($eventUrl)
            )->position(3),
        ]);
    }
}
