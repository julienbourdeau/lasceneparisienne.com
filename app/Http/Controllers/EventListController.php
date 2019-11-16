<?php

namespace App\Http\Controllers;

use App\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventListController extends Controller
{
    public function index()
    {
        $events = Event::with('venue')
            ->where('start_time', '>', Carbon::yesterday())
            ->orderBy('start_time')
            ->paginate(30);

        $eventsPerMonth = $events->groupBy(function ($e) {
            return $e->start_time->monthName.' '.$e->start_time->year;
        });

        return view('events.index', [
            'eventsPerMonth' => $eventsPerMonth,
            'events' => $events,
            'canonical' => route('events'),
        ]);
    }
}
