<?php

namespace App\Jobs;

use App\Models\TelegramUsers;
use App\Models\Tournaments;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramOtherException;
use Telegram\Bot\Exceptions\TelegramResponseException;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class NotifyAllUsersAboutNewTournamentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $tournaments ;
    public function __construct(Tournaments $tournaments)
    {
        $this->tournaments = $tournaments;
    }

    public function handle(): void
    {
        $Tournament = $this->tournaments;
        $Status = $Tournament->Status;
        $Mode = $Tournament->Mode;
        $Type = $Tournament->Type;
        $adwards = '';
        foreach ($Tournament->Awards as $key => $award) {
            $adwards .= 'Position ' . $key + 1 . ' = $' .$award ."\n";
        }

        $JalaliDate1 = Carbon::parse($Tournament->Start)->format('Y-M-d H:i');
        $JalaliDate2 = Carbon::parse($Tournament->End)->format('Y-M-d H:i');
        $GamesCount = $Tournament->PlayerCount - 1;

        $text = "
New Tournament : {$Tournament->Game->Name}
Name : {$Tournament->Name}
Description : {$Tournament->Description}
Type : {$Type}
Mode : {$Mode}
Entry  : $ {$Tournament->Price}
Players : {$Tournament->PlayerCount}
Start Date : {$JalaliDate1}
End Date : {$JalaliDate2}
Winners : {$Tournament->Winners}
Awards : \n {$adwards}
Status : {$Status}
for joining tournament go to krypto arena app.
";

        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

        try {
            $Users = TelegramUsers::where('UserName' , 'not like' , '%KryptoArenaFreePosition%')->get();
            foreach ($Users as $user) {
                $telegram->sendMessage([
                    'chat_id' => $user->TelegramUserID,
                    'text' => $text,
                    'parse_mode' => 'html',
                ]);
            }
        }catch (TelegramOtherException | TelegramResponseException $exception){
            Log::channel("Telegram")->error($exception->getMessage());
        }


        try {
            $ChanelID = Telegram::getChat(['chat_id' => '@krypto_arena']);
            $telegram->sendMessage([
                'chat_id' => $ChanelID['id'],
                'text' => $text,
                'parse_mode' => 'html',
            ]);
        }catch (TelegramOtherException | TelegramResponseException $exception){
            Log::channel("Telegram")->error($exception->getMessage());
        }




    }
}
