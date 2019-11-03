<?php

namespace App\Http\Controllers;

use App\Venue;
use Illuminate\Http\Request;

class VenueListController extends Controller
{
    public function index()
    {
        $venues = Venue::withCount('upcomingEvents')
            ->orderByDesc('upcoming_events_count')
            ->get();

        return view('venues.index', [
            'venues' => $venues
        ]);
    }
}
