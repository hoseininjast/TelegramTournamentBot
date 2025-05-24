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
        $Tournaments = Tournaments::all()->sortByDesc('id');
        return view('Dashboard.Tournaments.index')->with(['Tournaments' => $Tournaments]);
    }

    public function Open()
    {
        $Tournaments = Tournaments::where('Status' , 'Pending')->get()->sortByDesc('id');
        return view('Front.Tournaments.Open')->with(['Tournaments' => $Tournaments]);
    }
    public function List($GameID , $Mode)
    {
        $Game = Games::find($GameID);
        $Tournaments = Tournaments::where('GameID' , $Game->id)->where('Mode' , $Mode)->get()->sortByDesc('id');
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

    public function Champions()
    {
        /*Best inviters*/
        $MostReferrals = TelegramUsers::where('UserName' , 'not like' , '%KryptoArenaFreePosition%')->has('Referrals')->withCount('Referrals')->get()->sortByDesc('referrals_count');
        $MostReferrals = $MostReferrals->take(10);
        /*END Best inviters*/

        /*Champions*/
        $Champions = TournamentHistory::all();
        $Data = [];
        $key = 0;
        foreach ($Champions as $champion) {
            foreach ( $champion->Winners as $item) {
                $Data[$key] = $item;
                $key++;
            }
        }


        $occurrences = array_count_values($Data);
        $FinalChampions = [];
        foreach ($occurrences as $championid => $wincount) {
            $User = TelegramUsers::find($championid);
            $FinalChampions[] = [
                'ChampionID' => $championid,
                'WinCount' => $wincount,
                'Stars' => $User->Stars()->count()
            ];
        }

        $this->aasort($FinalChampions ,'Stars' );

        $FinalChampions = array_slice($FinalChampions, 0, 10);
        /*END Champions*/






        return view('Front.Tournaments.Champions')->with(['Champions' => $FinalChampions , 'MostReferrals' => $MostReferrals]);
    }

    function aasort (&$array, $key) {
        $sorter = array();
        $ret = array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii] = $va[$key];
        }
        arsort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii] = $array[$ii];
        }
        $array = $ret;
    }


}
