<?php

namespace App\Facebook;

use Facebook\PersistentData\PersistentDataInterface;
use Illuminate\Support\Facades\Session;

class PersistentDataHandler implements PersistentDataInterface
{

    /**
     * @var string Prefix to use for session variables.
     */
    protected $sessionPrefix = 'HXCWRLD_';

    /**
     * @inheritdoc
     */
    public function get($key)
    {
        return Session::get($this->sessionPrefix . $key);
    }

    /**
     * @inheritdoc
     */
    public function set($key, $value)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }

        Session::put($this->sessionPrefix . $key, $value);

        return $this;
    }
}
