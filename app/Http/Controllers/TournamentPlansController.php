<?php

namespace App\Http\Controllers;

use App\Classes\Number2Word;
use App\Jobs\NotifyTelegramUsersAboutTournamentJob;
use App\Jobs\NotifyTelegramUsersJob;
use App\Models\Tasks;
use App\Models\TelegramUsers;
use App\Models\TournamentPlans;
use App\Models\Tournaments;
use App\Models\User;
use App\Models\UserPaymentHistory;
use App\Models\UserTasks;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Telegram\Bot\Laravel\Facades\Telegram;

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

        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $SupervisorTelegramInfo = $telegram->getChat(['chat_id' => $Supervisor->TelegramUserID]);
        $SupervisorTelegramUsername = $SupervisorTelegramInfo['username'];

        $text = "
Your match supervisor has been identified.
Please contact him/her to arrange a time.
Game : {$TournamentPlan->Tournament->Game->Name}
Tournament : {$TournamentPlan->Tournament->Name}
Supervisor : Plato : {$Supervisor->PlatoID} ،‌ Telegram : @{$SupervisorTelegramUsername}
First Player : Plato : {$User1->PlatoID} ، Telegram : @{$User1->UserName}
Second Player : Plato : {$User2->PlatoID} ، Telegram : @{$User2->UserName}
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
        if(!\Auth::user()->isOwner()){
            if($TournamentPlan->SupervisorID != \Auth::id()){
                \Alert::error('you dont have access to this game plan');
                return redirect()->back();
            }
        }

        $TournamentPlan->update([
            'Player1Score' => $request->Player1Score,
            'Player2Score' => $request->Player2Score,
            'WinnerID' => $request->WinnerID,
            'Status' => 'Finished',
        ]);
        $User1 = $TournamentPlan->Player1->TelegramUserID;
        $User2 = $TournamentPlan->Player2->TelegramUserID;


        $JalaliDate = Carbon::parse($TournamentPlan->Time)->format('Y-M-d H:i');

        $text = "
The result of your match has been determined.
Game : {$TournamentPlan->Tournament->Game->Name}
Tournament : {$TournamentPlan->Tournament->Name}
Group : {$this->numToWords($TournamentPlan->Group)}
Stage : {$this->numToWordForStages($TournamentPlan->Stage)}
 Players :
 {$TournamentPlan->Player1->PlatoID} --- {$TournamentPlan->Player2->PlatoID}
 @{$TournamentPlan->Player1->UserName} --- @{$TournamentPlan->Player2->UserName}
 Points : First Player : {$request->Player1Score} --- Second Player : {$request->Player2Score}
 Start Date : {$JalaliDate}
 Winner : {$TournamentPlan->Winner->PlatoID}
You will be notified once the schedule for the next match in the app is determined.
";

        if(env('APP_ENV') == 'production'){
            if(preg_match('/KryptoArenaFreePosition/' , $TournamentPlan->Player1->UserName ) != 1){
                NotifyTelegramUsersJob::dispatch($User1 ,$text);
            }

            if(preg_match('/KryptoArenaFreePosition/' , $TournamentPlan->Player2->UserName ) != 1){
                NotifyTelegramUsersJob::dispatch($User2 ,$text);
            }
        }



        $Winner = TelegramUsers::find($TournamentPlan->WinnerID);
        $Matchs = TournamentPlans::where('WinnerID' , $Winner->id)->count();

        if($Matchs >= 10 && $Matchs < 24){


            $Task = Tasks::where('TaskID' , 'Match1')->first();
            $UserTask = UserTasks::create([
                'TaskID' => $Task->id,
                'UserID' => $Winner->id,
            ]);

            $Winner->update([
                'Charge' => $Winner->Charge + 1,
            ]);

            UserPaymentHistory::create([
                'UserID' => $Winner->id,
                'Description' => 'Task Finished => ' . $Task->Category .' : ' . $Task->Name,
                'Amount' => 1,
                'Type' => 'In',
            ]);


        }elseif($Matchs >= 25 && $Matchs < 49){


            $Task = Tasks::where('TaskID' , 'Match2')->first();
            $UserTask = UserTasks::create([
                'TaskID' => $Task->id,
                'UserID' => $Winner->id,
            ]);

            $Winner->update([
                'Charge' => $Winner->Charge + 2.5,
            ]);

            UserPaymentHistory::create([
                'UserID' => $Winner->id,
                'Description' => 'Task Finished => ' . $Task->Category .' : ' . $Task->Name,
                'Amount' => 2.5,
                'Type' => 'In',
            ]);

        }elseif($Matchs >= 50){


            $Task = Tasks::where('TaskID' , 'Match3')->first();
            $UserTask = UserTasks::create([
                'TaskID' => $Task->id,
                'UserID' => $Winner->id,
            ]);

            $Winner->update([
                'Charge' => $Winner->Charge + 5,
            ]);

            UserPaymentHistory::create([
                'UserID' => $Winner->id,
                'Description' => 'Task Finished => ' . $Task->Category .' : ' . $Task->Name,
                'Amount' => 5,
                'Type' => 'In',
            ]);

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
        if(!\Auth::user()->isOwner()){
            if($TournamentPlan->SupervisorID != \Auth::id()){
                \Alert::error('you dont have access to this game plan');
                return redirect()->back();
            }
        }

        $TournamentPlan->update([
            'Time' => $request->Time
        ]);
        $User1 = $TournamentPlan->Player1->TelegramUserID;
        $User2 = $TournamentPlan->Player2->TelegramUserID;

        $JalaliDate = Carbon::parse($TournamentPlan->Time)->format('Y-M-d H:i');

        $text = "
Your match time has been set.
Game : {$TournamentPlan->Tournament->Game->Name}
Tournament : {$TournamentPlan->Tournament->Name}
Group : {$this->numToWords($TournamentPlan->Group)}
Stage : {$this->numToWordForStages($TournamentPlan->Stage)}
 Players :
 {$TournamentPlan->Player1->PlatoID} --- {$TournamentPlan->Player2->PlatoID}
 @{$TournamentPlan->Player1->UserName} --- @{$TournamentPlan->Player2->UserName}
 Start Date : {$JalaliDate}
Please coordinate with the match supervisor 1 hour before the start of the match.
";



        if(env('APP_ENV') == 'production'){

            if(preg_match('/KryptoArenaFreePosition/' , $TournamentPlan->Player1->UserName ) != 1){
                NotifyTelegramUsersJob::dispatch($User1 ,$text);
            }

            if(preg_match('/KryptoArenaFreePosition/' , $TournamentPlan->Player2->UserName ) != 1){
                NotifyTelegramUsersJob::dispatch($User2 ,$text);
            }

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
