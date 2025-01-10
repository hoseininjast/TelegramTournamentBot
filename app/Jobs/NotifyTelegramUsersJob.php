<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Telegram\Bot\Api;
use Telegram\Bot\Laravel\Facades\Telegram;

class NotifyTelegramUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private $UserID , $Message , $telegram = null;
    public function __construct($UID  , $MSG)
    {
        $this->UserID = $UID;
        $this->Message = $MSG;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

        $this->telegram->sendMessage([
            'chat_id' => $this->UserID,
            'text' => $this->Message,
            'parse_mode' => 'html',
        ]);

    }
}
