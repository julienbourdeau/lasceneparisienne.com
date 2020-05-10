<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;

class Telegram
{
    private $token;
    private $chatId;

    public function __construct($token = null, $chatId = null)
    {
        $this->token = $token ?? config('services.telegram.secret');
        $this->chatId = $chatId ?? config('services.telegram.id');
    }

    public function send(string $message): int
    {
        return $this->post($message)->status();
    }

    private function post($message)
    {
        return Http::post("https://api.telegram.org/bot{$this->token}/sendMessage", [
            'chat_id' => $this->chatId,
            'text' => $message
        ]);
    }
}
