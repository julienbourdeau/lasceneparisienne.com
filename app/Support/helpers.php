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
