<?php

namespace App\Nova;

use App\Nova\Filters\StartDateFilter;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Panel;

class Event extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Event::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'slug',
    ];

    public static $with = ['venue'];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('name'),
            Text::make('Date', function ($m) {
                return '<strong>'.$m->start_time->diffForHumans().'</strong><br>'.$m->start_time->toDateString();
            })->asHtml(),
            BelongsTo::make('Venue')->searchable(),
            DateTime::make('Start time')->hideFromIndex(),
            DateTime::make('End time')->hideFromIndex(),

            new Panel('Time and description', [
                Boolean::make('canceled')->hideFromIndex(),
                Boolean::make('soldout')->hideFromIndex(),
                Textarea::make('Description'),
                Text::make('Cover')->hideFromIndex(),
                Text::make('Cover2', function ($m) {
                    return '<img src="'.$m->cover.'">';
                })->asHtml(),
            ]),

            new Panel('Technical', [
                Text::make('ticket_url')->hideFromIndex(),
                Code::make('meta')->json(),
                Text::make('uuid')->onlyOnDetail(),
                DateTime::make('deleted_at')->onlyOnDetail(),
                DateTime::make('created_at')->onlyOnDetail(),
                DateTime::make('updated_at')->onlyOnDetail(),
            ]),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new StartDateFilter(),
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
