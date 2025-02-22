<?php

namespace App\Http\Controllers\Front;

use App\Classes\Number2Word;
use App\Http\Controllers\Controller;
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
use App\Models\UserTournaments;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TournamentsController extends Controller
{

    public function index()
    {
        $Tournaments = Tournaments::all();
        return view('Dashboard.Tournaments.index')->with(['Tournaments' => $Tournaments]);
    }

    public function List($GameID , $Mode)
    {
        $Game = Games::find($GameID);
        $Tournaments = Tournaments::where('GameID' , $Game->id)->where('Mode' , $Mode)->get();
        return view('Front.Tournaments.index')->with(['Tournaments' => $Tournaments]);
    }
    public function Detail($TournamentID)
    {
        $Tournament = Tournaments::find($TournamentID);
        return view('Front.Tournaments.Details')->with(['Tournament' => $Tournament]);
    }
    public function Plan($TournamentID)
    {
        $Tournament = Tournaments::find($TournamentID);
        return view('Front.Tournaments.Plan')->with(['Tournament' => $Tournament]);
    }
    public function MyTournaments()
    {
        return view('Front.Tournaments.MyTournaments');
    }



}
