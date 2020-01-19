<?php

namespace App\Nova\Metrics;

use App\Event;
use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Trend;

class EventsPerMonth extends Trend
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->countByMonths($request, Event::class, 'start_time');
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            12 => '12 Months',
            6 => '6 Months',
        ];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
         return now()->addHour();
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'events-per-month';
    }
}
