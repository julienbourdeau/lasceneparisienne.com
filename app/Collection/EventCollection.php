<?php

namespace App\Collection;

use App\Event;
use Eluceo\iCal\Component\Calendar;
use Illuminate\Database\Eloquent\Collection;

class EventCollection extends Collection
{
    public function toIcalEvents()
    {
        return $this->map(function (Event $item) {
            return $item->toIcalEvent();
        })->toArray();
    }

    public function toIcalCalendar(): Calendar
    {
        $vCalendar = new Calendar(config('app.title'));

        return $vCalendar->setComponents($this->toIcalEvents());
    }
}
