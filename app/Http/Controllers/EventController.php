<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Spatie\SchemaOrg\Schema;

class EventController extends Controller
{
    public function show($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        return view('events.show', [
            'event' => $event,
            'breadcrumb' => $this->getBreadcrumb($event),
        ]);
    }

    public function getBreadcrumb(Event $event)
    {
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
                    ->setProperty('id', $venueUrl = route('venue', $event->venue->slug))
                    ->name($event->venue->name)
                    ->url($venueUrl)
                    ->identifier($venueUrl)
            )->position(2),
            Schema::listItem()->item(
                Schema::thing()
                    ->setProperty('id', $eventUrl = route('event', $event->slug))
                    ->name($event->name)
                    ->url($eventUrl)
                    ->identifier($eventUrl)
            )->position(3),
        ]);
    }
}
