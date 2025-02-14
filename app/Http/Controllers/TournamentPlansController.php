<?php

namespace App\Http\Controllers;

use App\Classes\Number2Word;
use App\Jobs\NotifyTelegramUsersAboutTournamentJob;
use App\Jobs\NotifyTelegramUsersJob;
use App\Models\TournamentPlans;
use App\Models\Tournaments;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TournamentPlansController extends Controller
{
    public function Manage(int $ID)
    {
        $TournamentPlan = TournamentPlans::find($ID);
        if(\Auth::user()->isOwner()){
            return view('Dashboard.TournamentPlan.Manage')->with(['TournamentPlan' => $TournamentPlan]);
        }else{
            if($TournamentPlan->SupervisorID != \Auth::id()){
                \Alert::error('you dont have access to this game plan');
                return redirect()->back();
            }
            return view('Dashboard.TournamentPlan.Manage')->with(['TournamentPlan' => $TournamentPlan]);
        }

    }
    public function JoinAsSupervisor(int $ID)
    {
        $TournamentPlan = TournamentPlans::find($ID);
        $TournamentPlan->update([
            'SupervisorID' => \Auth::id()
        ]);
        $User1 = $TournamentPlan->Player1;
        $User2 = $TournamentPlan->Player2;
        $Supervisor = \Auth::user();

        $text = "
ناظر بازی شما مشخص شد.
لطفا برای هماهنگی ساعت با او در ارتباط باشید.
بازی : {$TournamentPlan->Tournament->Game->Name}
نام : {$TournamentPlan->Tournament->Name}
ناظر : پلاتو : {$Supervisor->PlatoID} ،‌ تلگرام : @{$Supervisor->Username}
بازیکن اول : پلاتو : {$User1->PlatoID} ، تلگرام : @{$User1->UserName}
بازیکن دوم : پلاتو : {$User2->PlatoID} ، تلگرام : @{$User2->UserName}
";

        if(env('APP_ENV') == 'production'){
            NotifyTelegramUsersJob::dispatch($User1->TelegramUserID ,$text);
            NotifyTelegramUsersJob::dispatch($User2->TelegramUserID ,$text);
            NotifyTelegramUsersJob::dispatch($Supervisor->TelegramUserID ,$text);
        }


        \Alert::success('Tournament joined successfully');

        return redirect()->route('Dashboard.TournamentPlan.Manage' , $TournamentPlan->id);

    }
    public function Update(int $ID , Request $request)
    {
        $request->validate([
            'Player1Score' => 'required|integer',
            'Player2Score' => 'required|integer',
            'WinnerID' => 'required|integer|exists:telegram_users,id',
        ]);

        $TournamentPlan = TournamentPlans::find($ID);
        if($TournamentPlan->SupervisorID != \Auth::id()){
            \Alert::error('you dont have access to this game plan');
            return redirect()->back();
        }
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
بازی : {$TournamentPlan->Tournament->Game->Name}
نام : {$TournamentPlan->Tournament->Name}
گروه : {$this->numToWords($TournamentPlan->Group)}
مرحله : {$this->numToWordForStages($TournamentPlan->Stage)}
 بازیکن ها :
 {$TournamentPlan->Player1->PlatoID} --- {$TournamentPlan->Player2->PlatoID}
 @{$TournamentPlan->Player1->UserName} --- @{$TournamentPlan->Player2->UserName}
 امتیاز ها : بازیکن اول : {$request->Player1Score} --- بازیکن دوم : {$request->Player2Score}
 زمان بازی : {$JalaliDate}
 برنده : {$TournamentPlan->Winner->PlatoID}
 پس از مشخص شدن برنامه بازی های بعدی در ربات به شما اطلاع رسانی میشود.
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
        if($TournamentPlan->SupervisorID != \Auth::id()){
            \Alert::error('you dont have access to this game plan');
            return redirect()->back();
        }
        $TournamentPlan->update([
            'Time' => $request->Time
        ]);
        $User1 = $TournamentPlan->Player1->TelegramUserID;
        $User2 = $TournamentPlan->Player2->TelegramUserID;

        $JalaliDate = Verta($TournamentPlan->Time)->format('%A, %d %B  H:i ');

        $text = "
زمان مسابقه شما مشخص شد
بازی : {$TournamentPlan->Tournament->Game->Name}
نام : {$TournamentPlan->Tournament->Name}
گروه : {$this->numToWords($TournamentPlan->Group)}
مرحله : {$this->numToWordForStages($TournamentPlan->Stage)}
 بازیکن ها :
 {$TournamentPlan->Player1->PlatoID} --- {$TournamentPlan->Player2->PlatoID}
 @{$TournamentPlan->Player1->UserName} --- @{$TournamentPlan->Player2->UserName}
 زمان بازی : {$JalaliDate}
 لطفا 1 ساعت قبل از شروع مسابقه با ناظر بازی هماهنگ کنید.
";



        if(env('APP_ENV') == 'production'){
            NotifyTelegramUsersJob::dispatch($User1 ,$text);
            NotifyTelegramUsersJob::dispatch($User2 ,$text);

            NotifyTelegramUsersAboutTournamentJob::dispatch($TournamentPlan)->delay(Carbon::parse($TournamentPlan->Time)->subMinutes(15));

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
