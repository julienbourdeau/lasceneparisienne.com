<?php

namespace App\Support\Facades;

use App\Support\Telegram;
use Illuminate\Support\Facades\Facade;

class AdminNotification extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Telegram::class;
    }
}
