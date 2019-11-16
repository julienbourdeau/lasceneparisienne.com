<?php

namespace App\Http\Controllers;

use App\Venue;
use Illuminate\Http\Request;

class VenueListController extends Controller
{
    public function index()
    {
        $venues = Venue::withCount('upcomingEvents')
            ->orderBy('name')
            ->get()
            ->groupBy(function ($v) {
                return $v->name[0];
            });

        $top = Venue::withCount('upcomingEvents')->whereIn('id', [6, 7, 21, 22, 1])->get();

        return view('venues.index', [
            'venuesAlpha' => $venues,
            'top' => $top,
        ]);
    }
}
