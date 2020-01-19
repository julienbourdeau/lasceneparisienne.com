<?php

namespace App\Http\Controllers;

use App\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventListController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::with('venue')
            ->where('start_time', '>', Carbon::yesterday())
            ->orderBy('start_time')
            ->paginate(30);

        $eventsPerMonth = $events->groupBy(function ($e) {
            return $e->start_time->monthName.' '.$e->start_time->year;
        });

        $display = $request->get('display');
        if (!in_array($display, ['list', 'grid'])) {
            $display = 'list';
        }

        return view('events.index', [
            'eventsPerMonth' => $eventsPerMonth,
            'events' => $events,
            'monthlyLinks' => $this->getMonthlyLinks(),
            'canonical' => route('events'),
            'display' => $display,
        ]);
    }

    private function getMonthlyLinks()
    {
        $periods = DB::table('events')
            ->select(DB::raw('DATE_FORMAT(start_time, \'%Y-%m\') as period'))
            ->where('start_time', '>', now())
            ->groupBy('period')
            ->get()
            ->pluck('period');

        $monthList = $this->getMonthOfYear();

        return $periods->map(function ($period) use ($monthList) {
            list($year, $monthNumber) = explode('-', $period);
            return $monthList[$monthNumber - 1].' '.$year;
        })->mapWithKeys(function ($periodName) {
            return [$periodName => route('archives', str_slug($periodName))];
        });
    }
}
