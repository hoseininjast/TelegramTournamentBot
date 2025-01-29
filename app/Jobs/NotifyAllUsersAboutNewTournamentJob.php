<?php

namespace App\Jobs;

use App\Models\TelegramUsers;
use App\Models\Tournaments;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramOtherException;
use Telegram\Bot\Exceptions\TelegramResponseException;
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
        $Status = __('messages.Status.' . $Tournament->Status);
        $Mode = __('messages.Mode.' . $Tournament->Mode);
        $Type = __('messages.Type.' . $Tournament->Type);
        $adwards = '';
        foreach ($Tournament->Awards as $key => $award) {
            $adwards .= 'نفر ' . $key + 1 . ' = $' .$award ."\n";
        }

        $JalaliDate1 = Verta($Tournament->Start)->format('%A, %d %B  H:i ');
        $JalaliDate2 = Verta($Tournament->End)->format('%A, %d %B  H:i ');
        $GamesCount = $Tournament->PlayerCount - 1;

        $text = "
تورنومنت جدیدی ثبت شده است.
نام : {$Tournament->Name}
توضیحات : {$Tournament->Description}
نوع : {$Type}
حالت : {$Mode}
 مبلغ ورودی : $ {$Tournament->Price}
تعداد بازیکن : {$Tournament->PlayerCount}
زمان بازی : {$Tournament->Time} روز
تاریخ شروع : {$JalaliDate1}
تاریخ پایان : {$JalaliDate2}
مراحل : {$Tournament->TotalStage} مرحله
تعداد بازی : {$GamesCount} بازی
تعداد برندگان : {$Tournament->Winners}
جوایز : \n {$adwards}
وضعیت : {$Status}
برای شرکت در تورنومنت وارد ربات شوید.
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
