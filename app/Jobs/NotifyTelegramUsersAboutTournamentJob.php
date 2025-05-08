<?php

namespace App\Jobs;

use App\Classes\Number2Word;
use App\Models\TournamentPlans;
use Carbon\Carbon;
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

        $JalaliDate = Carbon::parse($this->TournamentPlan->Time)->format('Y-M-d H:i');
        if($this->TournamentPlan->SupervisorID){
            $SupervisorID = $this->TournamentPlan->Supervisor->PlatoID;
            $SupervisorTelegramInfo = $telegram->getChat(['chat_id' => $this->TournamentPlan->Supervisor->TelegramUserID]);
            $SupervisorTelegramUsername = $SupervisorTelegramInfo['username'];
        }else{
            $SupervisorID = 'Not specified';
            $SupervisorTelegramUsername = 'Not specified';
        }


        $text = "
Your match starts in 15 minutes.
If you do not come online within 5 minutes of the specified time in the game, the moderator will declare the opponent the winner.
Group : {$this->numToWords($this->TournamentPlan->Group)}
Stage : {$this->numToWordForStages($this->TournamentPlan->Stage)}
 Players :
 {$this->TournamentPlan->Player1->PlatoID} --- {$this->TournamentPlan->Player2->PlatoID}
 @{$this->TournamentPlan->Player1->UserName} --- @{$this->TournamentPlan->Player2->UserName}
 Start Date : {$JalaliDate}
Supervisor : Plato : {$SupervisorID} ،‌ Telegram : @{$SupervisorTelegramUsername}
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
