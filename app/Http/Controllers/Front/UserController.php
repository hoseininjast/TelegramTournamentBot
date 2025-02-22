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

class UserController extends Controller
{

    public function index()
    {
        return view('Dashboard.Tournaments.index');
    }
    public function Show($UserID)
    {
        $Tournament = Tournaments::find($TournamentID);
        return view('Front.Tournaments.Plan')->with(['Tournament' => $Tournament]);
    }


}
