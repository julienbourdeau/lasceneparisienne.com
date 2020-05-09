<?php

use Illuminate\Database\Eloquent\Model;
use League\CommonMark\CommonMarkConverter;

function currentUrl(array $parameters = [])
{
    return url()->toRoute(
        \Illuminate\Support\Facades\Route::current(),
        array_merge(request()->all(), $parameters),
        true
    );
}

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

function adminLink(Model $model, $action = '')
{
    $resource = Str::plural(Str::kebab(class_basename(get_class($model))));

    return "/admin/resources/{$resource}/{$model->id}/{$action}";
}

function adminView(Model $model)
{
    return adminLink($model);
}

function adminEdit(Model $model)
{
    return adminLink($model, 'edit');
}

function markdown($md)
{
    return app(CommonMarkConverter::class)->convertToHtml($md);
}
