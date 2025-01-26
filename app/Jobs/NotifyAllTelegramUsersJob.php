<?php

namespace App\Jobs;

use App\Models\TelegramUsers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Telegram\Bot\Api;
use Telegram\Bot\Laravel\Facades\Telegram;

class NotifyAllTelegramUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private $Message , $telegram = null;
    public function __construct($MSG)
    {
        $this->Message = $MSG;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

        $Users = TelegramUsers::where('UserName' , 'not like' , '%KryptoArenaFreePosition%')->get();

        foreach ($Users as $user) {
            $telegram->sendMessage([
                'chat_id' => $user->TelegramUserID,
                'text' => $this->Message,
                'parse_mode' => 'html',
            ]);
        }


    }
}
