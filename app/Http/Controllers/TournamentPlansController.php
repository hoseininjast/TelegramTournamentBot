<?php

namespace App\Http\Controllers;

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
            'Time' => $request->Time
        ]);
        \Alert::success('Tournament created successfully');

        return redirect()->back();

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

        $Stage = $TournamentPlan->Stage == 1 ? 'اول' : ( $TournamentPlan->Stage == 2 ? 'دوم' : ( $TournamentPlan->Stage == 3 ? 'سوم' : ( $TournamentPlan->Stage == 4 ? 'چهارم' : ( $TournamentPlan->Stage == 5 ? 'پنجم' : 'ششم' ))));

        $text = "
زمان مسابقه شما مشخص شد
گروه : {$TournamentPlan->Group}
مرحله : {$Stage}
 بازیکن ها :
 {$TournamentPlan->Player1->PlatoID} در برابر {$TournamentPlan->Player2->PlatoID}
 زمان بازی : {$request->Time}
 لطفا 1 ساعت قبل از شروع مسابقه با ناظر بازی هماهنگ کنید.
@krypto_arena_bot
";

        NotifyTelegramUsersJob::dispatch($User1 ,$text);
        NotifyTelegramUsersJob::dispatch($User2 ,$text);


        \Alert::success('Tournament created successfully');

        return redirect()->back();
    }
}
