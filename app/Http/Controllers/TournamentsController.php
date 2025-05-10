<?php

namespace App\Http\Controllers;

use App\Classes\Number2Word;
use App\Http\Traits\Uploader;
use App\Jobs\NotifyAllTelegramUsersJob;
use App\Jobs\NotifyAllUsersAboutNewTournamentJob;
use App\Jobs\NotifyTelegramUsersJob;
use App\Models\Games;
use App\Models\TelegramUsers;
use App\Models\TournamentHistory;
use App\Models\TournamentPlans;
use App\Models\Tournaments;
use App\Models\User;
use App\Models\UserPaymentHistory;
use App\Models\UserTournaments;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TournamentsController extends Controller
{
    use Uploader;

    public function index()
    {
        $Tournaments = Tournaments::all()->sortDesc();
        confirmDelete('Delete Tournament!', 'Are you sure you want to delete this Tournament?');
        return view('Dashboard.Tournaments.index')->with(['Tournaments' => $Tournaments]);
    }
    public function Add()
    {
        $Games = Games::all();
        return view('Dashboard.Tournaments.Add')->with(['Games' => $Games]);
    }
    public function Manage(int $ID)
    {
        $Tournament = Tournaments::find($ID);
        $TournamentPlans = TournamentPlans::where('TournamentID' , $Tournament->id)->where('SupervisorID' , '!=' , null)->get('SupervisorID');
        $Supervisorids = [];
        foreach ($TournamentPlans as $tournamentPlan) {
            $Supervisorids[] = $tournamentPlan->SupervisorID;
        }
        $Supervisors = User::whereIn('id' , $Supervisorids)->get();
        confirmDelete('Remove User From Tournament', 'Are you sure you want to remove this user? user will be notified about this action');

        return view('Dashboard.Tournaments.Manage')->with(['Tournament' => $Tournament , 'Supervisors' => $Supervisors]);
    }
    public function Edit(int $ID)
    {
        $Tournament = Tournaments::find($ID);
        $Games = Games::all();
        return view('Dashboard.Tournaments.Edit')->with(['Tournament' => $Tournament , 'Games' => $Games]);
    }

    public function Update(int $ID , Request $request)
    {
        $request->validate([
            'Name' => 'required|string',
            'Description' => 'required|string',
            'Image' => 'nullable|file|image',
            'PlayerCount' => 'required|integer',
            'TotalStage' => 'required|integer',
            'Type' => 'required|string|in:Knockout,WorldCup,League',
            'Mode' => 'required|string|in:Free,Paid',
            'Price' => 'required|integer',
            'Time' => 'required|integer',
            'Start' => 'required|date_format:Y-m-d H:i:s',
            'End' => 'required|date_format:Y-m-d H:i:s',
            'GameID' => 'required|integer|exists:games,id',
            'Winners' => 'required|integer',
            'Awards' => 'required|array',
            'StagesDate' => 'required|array',
        ]);
        $Tournament = Tournaments::find($ID);

        if($request->hasFile('Image')){
            $AttachmentAddress = $this->UploadImage($request->Image , 'Tournaments');
        }else{
            $AttachmentAddress = $Tournament->GetImage();
        }
        $Tournament->update([
            'Name' => $request->Name,
            'Description' => $request->Description,
            'Image' => $AttachmentAddress,
            'PlayerCount' => $request->PlayerCount,
            'TotalStage' => $request->TotalStage,
            'Type' => $request->Type,
            'Mode' => $request->Mode,
            'Price' => $request->Price,
            'Time' => $request->Time,
            'Start' => $request->Start,
            'End' => $request->End,
            'GameID' => $request->GameID,
            'Winners' => $request->Winners,
            'Awards' => $request->Awards,
            'StagesDate' => $request->StagesDate,
        ]);



        \Alert::success('Tournament Updated successfully');


        return redirect()->route('Dashboard.Tournaments.index');
    }

    public function Fill(int $ID)
    {
        $Tournament = Tournaments::find($ID);
        if($Tournament->Players->count() < $Tournament->PlayerCount){
            $RemainingCount = $Tournament->PlayerCount - $Tournament->Players->count();
            $LastFakeUser = TelegramUsers::where('UserName' , 'like' , '%KryptoArenaFreePosition%')->orderBy('id', 'DESC')->first();
            $LastID = preg_replace('/KryptoArenaFreePosition/' , '' , $LastFakeUser->UserName);
            for($i = 0; $i < $RemainingCount; $i++){
                $LastID++;
                $User = TelegramUsers::create([
                    'TelegramUserID' => $LastID,
                    'TelegramChatID' => $LastID,
                    'UserName' => 'KryptoArenaFreePosition' . $LastID,
                    'PlatoID' => 'KryptoArenaFreePosition' . $LastID,
                ]);
                UserTournaments::create([
                    'UserID' => $User->id,
                    'TournamentID' => $Tournament->id,
                ]);
            }
            Alert::success('tournament filled with user and now you can start it.');
        }else{
            Alert::error('this tournament has been filled with user');
        }


        return redirect()->route('Dashboard.Tournaments.Manage' ,$Tournament->id );

    }
    public function StartStage1(int $ID)
    {
        $Tournament = Tournaments::find($ID);
        if($Tournament->LastStage == 0){
            $Stages = $Tournament->StagesDate;
            $Stage1Time = $Stages[0];
            $Stage2Time = $Stages[1];
            $PlayerList = $Tournament->Players;
            $PlayerIDs = null;
            foreach ( $PlayerList as $playerID) {
                $PlayerIDs[] =  $playerID->UserID;
            }

            shuffle($PlayerIDs);
            $Group = 1;
            $NextStage = $Tournament->LastStage + 1;
            for ($i = 0; $i < count($PlayerIDs) ; $i += 2 , $Group++) {
                TournamentPlans::create([
                    'TournamentID' => $Tournament->id,
                    'Stage' => $NextStage,
                    'Group' => $Group,
                    'Player1ID' => $PlayerIDs[$i],
                    'Player2ID' => $PlayerIDs[$i+1],
                    'Time' => $Stage1Time,
                ]);


                $User1 = TelegramUsers::find($PlayerIDs[$i]);
                $User2 = TelegramUsers::find($PlayerIDs[$i+1]);

                $JalaliDate1 = Carbon::parse($Stage1Time)->format('Y-M-d H:i');
                $JalaliDate2 = Carbon::parse($Stage2Time)->format('Y-M-d H:i');

                $text = "
Your match plan has been determined.
Game : {$Tournament->Game->Name}
Tournament : {$Tournament->Name}
Group : {$this->numToWords($Group)}
Stage : {$this->numToWordForStages($NextStage)}
 Players :
 {$User1->PlatoID} --- {$User2->PlatoID}
 @{$User1->UserName} --- @{$User2->UserName}
 Start : {$JalaliDate1} to {$JalaliDate2} Please coordinate with your supervisor at this time.
Match time will be announced soon.
";

                if(env('APP_ENV') == 'production'){

                    if(preg_match('/KryptoArenaFreePosition/' , $User1->UserName ) != 1){
                        NotifyTelegramUsersJob::dispatch($User1->TelegramUserID ,$text);
                    }

                    if(preg_match('/KryptoArenaFreePosition/' , $User2->UserName ) != 1){
                        NotifyTelegramUsersJob::dispatch($User2->TelegramUserID ,$text);
                    }
                }

            }
            $Tournament->update([
                'LastStage' => 1,
                'Status' => 'Running',
            ]);

            Alert::success('Tournament Plan created successfully');

        }else{
            Alert::error('this tournament has been played stage 1');
        }


        return redirect()->route('Dashboard.Tournaments.Manage' ,$Tournament->id );
    }
    public function StartNextStage(int $ID )
    {
        $Tournament = Tournaments::find($ID);
        $CurrentStage = $Tournament->LastStage;
        $NextStage = $Tournament->LastStage + 1;

        if($Tournament->Plans()->where('Stage' , $CurrentStage)->count() == $Tournament->Plans()->where('Stage' , $CurrentStage)->where('Status' , 'Finished')->count()){

            $GameGroups = $Tournament->Plans()->where('Stage' , $CurrentStage)->where('Status' , 'Finished')->get();

            $Stages = $Tournament->StagesDate;
            $CurrentStageTime = $Stages[$Tournament->LastStage ];
            if($NextStage == $Tournament->TotalStage){
                $NextStageTime = Carbon::parse($CurrentStageTime)->addDay();
            }else{
                $NextStageTime = $Stages[$Tournament->LastStage + 1 ];
            }



            $TotalGroup = $GameGroups->count() / 2;
            $CurrentGroup = 1;



            $JalaliDate1 = Carbon::parse($CurrentStageTime)->format('Y-M-d H:i');
            $JalaliDate2 = Carbon::parse($NextStageTime)->format('Y-M-d H:i');


            for ($i = 0 , $o = 0 ; $o < $TotalGroup ; $i += 2 ,$o++ , $CurrentGroup++) {

                TournamentPlans::create([
                    'TournamentID' => $Tournament->id,
                    'Stage' => $NextStage,
                    'Group' => $CurrentGroup,
                    'Player1ID' => $GameGroups[$i]->WinnerID,
                    'Player2ID' => $GameGroups[$i+1]->WinnerID,
                    'Time' => $CurrentStageTime,
                ]);


                $User1 = TelegramUsers::find($GameGroups[$i]->WinnerID);
                $User2 = TelegramUsers::find($GameGroups[$i+1]->WinnerID);


                $text = "
Your new match schedule has been announced.
Game : {$Tournament->Game->Name}
Tournament : {$Tournament->Name}
Group : {$this->numToWords($CurrentGroup)}
Stage : {$this->numToWordForStages($NextStage)}
 Players :
 {$User1->PlatoID} --- {$User2->PlatoID}
 @{$User1->UserName} --- @{$User2->UserName}
 Start : {$JalaliDate1} to {$JalaliDate2} Please coordinate with your supervisor at this time.
Match time will be announced soon.
";

                if(env('APP_ENV') == 'production'){

                    if(preg_match('/KryptoArenaFreePosition/' , $User1->UserName ) != 1){
                        NotifyTelegramUsersJob::dispatch($User1->TelegramUserID ,$text);
                    }

                    if(preg_match('/KryptoArenaFreePosition/' , $User2->UserName ) != 1){
                        NotifyTelegramUsersJob::dispatch($User2->TelegramUserID ,$text);
                    }
                }



            }



            $Tournament->update([
                'LastStage' => $NextStage
            ]);

            Alert::success("Tournament Stage {$NextStage} Plan created successfully");

        }else{
            Alert::error('this tournament has been played stage 1');
        }


        return redirect()->route('Dashboard.Tournaments.Manage' ,$Tournament->id );
    }

    public function ClosePage(int $ID )
    {
        $Tournament = Tournaments::find($ID);
        $CurrentStage = $Tournament->LastStage;
        if($Tournament->TotalStage == $Tournament->LastStage){
            if($Tournament->Plans()->where('Stage' , $CurrentStage)->count() == $Tournament->Plans()->where('Stage' , $CurrentStage)->where('Status' , 'Finished')->count()){

                $NumberOne = $Tournament->Plans()->where('Stage' , $CurrentStage)->where('Status' , 'Finished')->first()->Winner;

                $Numbers = $Tournament->Plans()->where('Stage' , $CurrentStage - 1)->where('Status' , 'Finished')->get();

                $Players[] = $Numbers[0]->Player1 ;
                $Players[] = $Numbers[0]->Player2 ;
                $Players[] = $Numbers[1]->Player1 ;
                $Players[] = $Numbers[1]->Player2 ;


                return view('Dashboard.Tournaments.Close')->with(['Tournament' => $Tournament , 'Players' => $Players]);

            }else{
                Alert::error('this tournament has been played stage 1');
                return redirect()->back();
            }
        }else{
            Alert::error('all stages must play and end for closing tournament');
            return redirect()->back();
        }




    }

    public function Close(int $ID , Request $request)
    {
        $request->validate([
            'Winner' => 'required|array',
            'Image' => 'nullable|file|image',
        ]);

        $Tournament = Tournaments::find($ID);
        $CurrentStage = $Tournament->LastStage;

        if($Tournament->Plans()->where('Stage' , $CurrentStage)->count() == $Tournament->Plans()->where('Stage' , $CurrentStage)->where('Status' , 'Finished')->count()){
            $Players = [];
            $key = 1;
            $Winners = '';
            foreach ($request->Winner as $player) {
                $User = TelegramUsers::find($player);
                $Players[$key] = $User->id;
                $Winners .= "Position ". $this->numToWordForStages($key) ." : ". $User->PlatoID ." => $". $Tournament->Awards[$key - 1 ] ." \n";
                $key++;

                UserPaymentHistory::create([
                    'UserID' => $User->id,
                    'Description' => "Tournament Win : {$Tournament->Name}",
                    'Amount' => $Tournament->Awards[$key - 1 ],
                    'Currency' => 'KAT',
                    'Type' => 'In',
                ]);

                $User->update([
                    'KAT' => $User->KAT + $Tournament->Awards[$key - 1 ]
                ]);
            }
            if($request->hasFile('Image')){
                $AttachmentAddress = $this->UploadImage($request->Image , 'TournamentsHistory');
            }else{
                $AttachmentAddress = null;
            }

            TournamentHistory::create([
                'TournamentID' => $Tournament->id,
                'Winners' => $Players,
                'Image' => $AttachmentAddress,
            ]);
            $Tournament->update([
                'Status' => 'Finished'
            ]);
            $text = "
The tournament is over.
Tournament  : {$Tournament->Name}
Winners :
{$Winners}
Prizes have been deposited and can be withdrawn through the app.
Stay tuned for more tournaments.
";
            if(env('APP_ENV') == 'production'){
                NotifyAllTelegramUsersJob::dispatch($text);
            }


            Alert::success('Tournament Finished successfully');

            return redirect()->route('Dashboard.Tournaments.index');


        }else{
            Alert::error('this tournament has not been finished and cannot closed');
            return redirect()->back();
        }


    }
    public function Create(Request $request)
    {
        $request->validate([
            'Name' => 'required|string',
            'Description' => 'required|string',
            'Image' => 'required|file|image',
            'PlayerCount' => 'required|integer',
            'TotalStage' => 'required|integer',
            'Type' => 'required|string|in:Knockout,WorldCup,League',
            'Mode' => 'required|string|in:Free,Paid',
            'Price' => 'required|numeric',
            'Time' => 'required|integer',
            'Start' => 'required|date_format:Y-m-d H:i:s',
            'End' => 'required|date_format:Y-m-d H:i:s',
            'GameID' => 'required|integer|exists:games,id',
            'Winners' => 'required|integer',
            'Awards' => 'required|array',
            'StagesDate' => 'required|array',
        ]);
        if($request->hasFile('Image')){
            $AttachmentAddress = $this->UploadImage($request->Image , 'Tournaments');
        }else{
            $AttachmentAddress = 'https://kryptoarena.fun/images/MainLogo.png';
        }


        $Tournament = Tournaments::create([
            'Name' => $request->Name,
            'Description' => $request->Description,
            'Image' => $AttachmentAddress,
            'PlayerCount' => $request->PlayerCount,
            'TotalStage' => $request->TotalStage,
            'LastStage' => 0,
            'Type' => $request->Type,
            'Mode' => $request->Mode,
            'Price' => $request->Price,
            'Time' => $request->Time,
            'Start' => $request->Start,
            'End' => $request->End,
            'GameID' => $request->GameID,
            'Winners' => $request->Winners,
            'Awards' => $request->Awards,
            'StagesDate' => $request->StagesDate,
            'Status' => 'Pending',
        ]);

        NotifyAllUsersAboutNewTournamentJob::dispatch($Tournament);


        \Alert::success('Tournament created successfully');


        return redirect()->route('Dashboard.Tournaments.index');
    }

    public function Delete(int $ID)
    {
        $Tournament = Tournaments::find($ID);
        $Tournament->delete();
        Alert::success('Tournament Deleted successfully');
        return redirect()->route('Dashboard.Tournaments.index');

    }

    public function RemoveUser(int $TournamentUserID)
    {
        $UserTournament = UserTournaments::find($TournamentUserID);
        $Tournament = Tournaments::find($UserTournament->TournamentID);
        $User = TelegramUsers::find($UserTournament->UserID);

        if($Tournament->Status != 'Pending'){
            Alert::error("you cant remove user from {$Tournament->Status} tournament");
        }else{
            $text = "
You have been removed from the following tournament:
Tournament : {$Tournament->Name}
Game : {$Tournament->Game->Name}
You can ask the supervisor the reason for your removal.
";
            if(env('APP_ENV') == 'production'){
                if(preg_match('/KryptoArenaFreePosition/' , $User->UserName ) != 1){
                    NotifyTelegramUsersJob::dispatch($User->TelegramUserID ,$text);
                }
            }
            $UserTournament->delete();
            Alert::success('User Removed from tournament successfully');
        }

        return redirect()->back();

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
