<?php

namespace App\Http\Controllers;

use App\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function show($slug)
    {
        $venue = Venue::where('slug', $slug)->firstOrFail();

        return view('venues.show', [
            'venue' => $venue,
        ]);
    }
}
