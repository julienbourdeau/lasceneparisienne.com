<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Controllers\Controller;
use App\Venue;

class PublicController extends Controller
{
    public function events()
    {
        return Event::paginate();
    }

    public function event($uuid)
    {
        return Event::where('uuid', $uuid)->firstOrFail();
    }

    public function venues()
    {
        return Venue::withCount(['upcomingEvents'])->paginate();
    }

    public function venue($uuid)
    {
        return Venue::where('uuid', $uuid)
            ->withCount(['upcomingEvents', 'events'])
            ->with(['nextEvents'])
            ->firstOrFail();
    }
}
