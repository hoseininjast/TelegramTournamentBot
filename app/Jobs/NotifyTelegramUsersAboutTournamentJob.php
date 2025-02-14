<?php

namespace App\Jobs;

use App\Classes\Number2Word;
use App\Models\TournamentPlans;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Telegram\Bot\Api;
use Telegram\Bot\Laravel\Facades\Telegram;

class NotifyTelegramUsersAboutTournamentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private  $TournamentPlan , $telegram = null;
    public function __construct(TournamentPlans $TournamentPlan)
    {
        $this->TournamentPlan = $TournamentPlan;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

        $JalaliDate = Verta($this->TournamentPlan->Time)->format('%A, %d %B  H:i ');
        $SupervisorID = $this->TournamentPlan->SupervisorID ? $this->TournamentPlan->Supervisor->PlatoID : 'مشخص نشده';


        $text = "
۱۵ دقیقه دیگر بازی شما آغاز میشود .
اگر تا ۵ دقیقه پس از ساعت مشخص شده در بازی آنلاین نشوید ، ناظر حریف را برنده اعلام میکند.
گروه : {$this->numToWords($this->TournamentPlan->Group)}
مرحله : {$this->numToWordForStages($this->TournamentPlan->Stage)}
 بازیکن ها :
 {$this->TournamentPlan->Player1->PlatoID} --- {$this->TournamentPlan->Player2->PlatoID}
 @{$this->TournamentPlan->Player1->UserName} --- @{$this->TournamentPlan->Player2->UserName}
 زمان بازی : {$JalaliDate}
 ناظر شما : {$SupervisorID}
@krypto_arena_bot
";


        if(preg_match('/KryptoArenaFreePosition/' , $this->TournamentPlan->Player1->UserName ) != 1){
            $telegram->sendMessage([
                'chat_id' => $this->TournamentPlan->Player1->TelegramUserID,
                'text' => $text,
                'parse_mode' => 'html',
            ]);
        }


        if(preg_match('/KryptoArenaFreePosition/' , $this->TournamentPlan->Player2->UserName ) != 1){
            $telegram->sendMessage([
                'chat_id' => $this->TournamentPlan->Player2->TelegramUserID,
                'text' => $text,
                'parse_mode' => 'html',
            ]);
        }




        if($this->TournamentPlan->SupervisorID != null){
            $telegram->sendMessage([
                'chat_id' => $this->TournamentPlan->Supervisor->TelegramUserID,
                'text' => $text,
                'parse_mode' => 'html',
            ]);
        }



    }





    private function numToWords($number) {
        $N2W = new Number2Word();
        return $N2W->numberToWords($number);
    }
    private function numToWordForStages($number) {

        $N2W = new Number2Word();
        return $N2W->numToWordForStages($number);
    }





}
