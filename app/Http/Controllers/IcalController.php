<?php

namespace App\Http\Controllers;

use App\Event;

class IcalController extends Controller
{
    public function feed()
    {
        return response(Event::all()->toIcalCalendar()->render())
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="cal.ics"');
    }
}
