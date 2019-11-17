<?php

namespace App\Collection;

use App\Venue;
use Illuminate\Database\Eloquent\Collection;

class VenueCollection extends Collection
{
    public function toMapPoints()
    {
        return $this->map(function (Venue $item) {
            return $item->toMapPoint();
        })->toArray();
    }
}
