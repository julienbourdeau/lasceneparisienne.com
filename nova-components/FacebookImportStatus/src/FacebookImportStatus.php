<?php

namespace Lsp\FacebookImportStatus;

use App\Event;
use Laravel\Nova\Card;

class FacebookImportStatus extends Card
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
        return 'facebook-import-status';
    }

    public function lastRun()
    {
        $date = carbon(Event::max('created_at'));

        return $this->withMeta([
            'lastImported' => $date->toDayDateTimeString(),
            'lastCount' => Event::where('created_at', '>', $date->subHour())->count(),
        ]);
    }
}
