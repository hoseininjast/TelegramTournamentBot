<?php

namespace App\Http\Controllers;

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
        return view('Dashboard.TournamentPlan.Manage')->with(['TournamentPlan' => $TournamentPlan]);

    }
}
