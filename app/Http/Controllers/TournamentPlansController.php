<?php

namespace App\Http\Controllers;

use App\Classes\Number2Word;
use App\Jobs\NotifyTelegramUsersJob;
use App\Models\TournamentPlans;
use App\Models\Tournaments;
use Illuminate\Http\Request;

class TournamentPlansController extends Controller
{
    public function Manage(int $ID)
    {
        $TournamentPlan = TournamentPlans::find($ID);
        return view('Dashboard.TournamentPlan.Manage')->with(['TournamentPlan' => $TournamentPlan]);

    }
    public function Update(int $ID , Request $request)
    {
        $request->validate([
            'Player1Score' => 'required|integer',
            'Player2Score' => 'required|integer',
            'WinnerID' => 'required|integer|exists:telegram_users,id',
        ]);

        $TournamentPlan = TournamentPlans::find($ID);
        $TournamentPlan->update([
            'Player1Score' => $request->Player1Score,
            'Player2Score' => $request->Player2Score,
            'WinnerID' => $request->WinnerID,
            'Status' => 'Finished',
        ]);
        $User1 = $TournamentPlan->Player1->TelegramUserID;
        $User2 = $TournamentPlan->Player2->TelegramUserID;


        $JalaliDate = Verta($TournamentPlan->Time)->format('%A, %d %B  H:i ');

        $text = "
نتیجه بازی شما مشخص شد
گروه : {$this->numToWords($TournamentPlan->Group)}
مرحله : {$this->numToWordForStages($TournamentPlan->Stage)}
 بازیکن ها :
 {$TournamentPlan->Player1->PlatoID} --- {$TournamentPlan->Player2->PlatoID}
 امتیاز ها : {$request->Player1Score} : {$request->Player2Score}
 زمان بازی : {$JalaliDate}
 برنده : {$TournamentPlan->Winner->PlatoID}
 پس از مشخص شدن برنامه بازی های بعدی در ربات به شما اطلاع رسانی میشود.
@krypto_arena_bot
        ";

        if(env('APP_ENV') == 'production'){
            NotifyTelegramUsersJob::dispatch($User1 ,$text);
            NotifyTelegramUsersJob::dispatch($User2 ,$text);
        }



        \Alert::success('Tournament created successfully');

        return redirect()->route('Dashboard.Tournaments.Manage' , $TournamentPlan->TournamentID);


    }
    public function SetTime(int $ID , Request $request)
    {
        $request->validate([
            'Time' => 'required|date_format:Y-m-d H:i:s',
        ]);
        $TournamentPlan = TournamentPlans::find($ID);
        $TournamentPlan->update([
            'Time' => $request->Time
        ]);
        $User1 = $TournamentPlan->Player1->TelegramUserID;
        $User2 = $TournamentPlan->Player2->TelegramUserID;

        $JalaliDate = Verta($TournamentPlan->Time)->format('%A, %d %B  H:i ');

        $text = "
زمان مسابقه شما مشخص شد
گروه : {$this->numToWords($TournamentPlan->Group)}
مرحله : {$this->numToWordForStages($TournamentPlan->Stage)}
 بازیکن ها :
 {$TournamentPlan->Player1->PlatoID} --- {$TournamentPlan->Player2->PlatoID}
 زمان بازی : {$JalaliDate}
 لطفا 1 ساعت قبل از شروع مسابقه با ناظر بازی هماهنگ کنید.
@krypto_arena_bot
";

        if(env('APP_ENV') == 'production'){
            NotifyTelegramUsersJob::dispatch($User1 ,$text);
            NotifyTelegramUsersJob::dispatch($User2 ,$text);
        }


        \Alert::success('Tournament created successfully');

        return redirect()->route('Dashboard.Tournaments.Manage' , $TournamentPlan->TournamentID);
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
