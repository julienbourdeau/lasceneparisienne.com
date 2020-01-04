<?php

namespace Lsp\EventOverview;

use App\Event;
use Laravel\Nova\Card;

class EventOverview extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = '1/3';

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'event-overview';
    }

    public function overview()
    {
        return $this->withMeta([
            'total' => Event::count(),
            'upcoming' => Event::where('start_time', '>', now()->subDay())->count(),
        ]);
    }
}
