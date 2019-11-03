<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $events = Event::limit(3)->get();

        return view('home', [
            'events' => $events,
        ]);
    }
}
