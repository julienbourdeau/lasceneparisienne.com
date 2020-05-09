<?php

namespace App\Http\Controllers;

use App\Event;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __invoke()
    {
        $thisWeek = Event::where([
            ['start_time', '>=', Carbon::yesterday()],
            ['start_time', '<=', $monday = now()->next(Carbon::MONDAY)],
        ])->get();

        $nextWeek = Event::where([
            ['start_time', '>=', clone $monday],
            ['start_time', '<=', $monday->addWeek()],
        ])->get();

        return view('home', [
            'thisWeek' => $thisWeek,
            'nextWeek' => $nextWeek,
        ]);
    }
}
