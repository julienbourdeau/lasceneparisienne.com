<?php

namespace App\Http\Controllers;

use App\Venue;
use Carbon\Carbon;

class VenueController extends Controller
{
    public function show($slug)
    {
        $venue = Venue::where('slug', $slug)->firstOrFail();

        return view('venues.show', [
            'venue' => $venue,
            'upcomingEvents' => $venue->events()->where('start_time', '>', Carbon::yesterday())->get(),
            'pastEvents' => $venue->events()->where('start_time', '<', Carbon::yesterday())->get(),
        ]);
    }
}
