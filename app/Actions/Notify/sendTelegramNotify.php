<?php

namespace App\Actions\Notify;

use Illuminate\Support\Facades\Http;

class sendTelegramNotify
{
    public string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function send()
    {
        $token = env('TELEGRAM_TOKEN');
        $chat_id = env('TELEGRAM_CHAT_ID');
        if($token === null || $token === '') return false;
        if($chat_id === null || $chat_id === '') return false;
        return Http::get("https://api.telegram.org/bot{$token}/sendMessage", [
            "chat_id" => $chat_id,
            "text" => $this->message,
        ])->body();
    }
}
