<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index($period = null)
    {
        $current = $this->getMonthOfYear()->get(($now = now())->month - 1)
            .' '.$now->year;

        $periodPerYears = $this->getMonthList();
        $validPeriodSlug = $periodPerYears->flatten()->map(function ($period) {
            return str_slug($period);
        });

        if (is_null($period)) {
            $events = [];
        } elseif ($validPeriodSlug->contains($period)) {
            $start = $this->periodToDate($period);
            $end = clone $start;
            $events = Event::where([
                ['start_time', '>=', $start],
                ['start_time', '<=', $end->addMonth()],
            ])->get();
        } else {
            return abort(404);
        }

        return view('events.archive', [
            'count' => Event::count(),
            'years' => $periodPerYears,
            'current' => $current,
            'events' => $events,
            'period' => $period,
            'start' => $start ?? null,
        ]);
    }

    private function getMonthList()
    {
        $max = carbon(Event::max('start_time'));

        return collect(range(2019, $max->year))
            ->mapWithKeys(function ($year) {
                $monthList = $this->getMonthOfYear()->map(function ($name) use ($year) {
                    return $name.' '.$year;
                });

                return [$year => $monthList];
            });
    }

    public function periodToDate($period)
    {
        list($mois, $year) = explode('-', $period);
        $month = [
            'janvier' => 'January',
            'fevrier' => 'February',
            'mars' => 'March',
            'avril' => 'April',
            'mai' => 'May',
            'juin' => 'June',
            'juillet' => 'July',
            'aout' => 'August',
            'septembre' => 'September',
            'octobre' => 'October',
            'novembre' => 'November',
            'decembre' => 'December',
        ][$mois];

        return carbon($month.' '.$year);
    }
}
