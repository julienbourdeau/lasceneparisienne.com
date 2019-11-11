<?php

use Illuminate\Database\Eloquent\Model;

function canonical(Model $model)
{
    if ($model instanceof \App\Event) {
        return route('event', $model->slug);
    } elseif ($model instanceof \App\Venue) {
        return route('venue', $model->slug);
    }

    throw new InvalidArgumentException('Cannot generate canonical URL for model'.get_class($model));
}

function carbon($time)
{
    if (is_numeric($time)) {
        return \Carbon\Carbon::createFromTimestamp($time);
    }

    return new \Carbon\Carbon($time);
}
