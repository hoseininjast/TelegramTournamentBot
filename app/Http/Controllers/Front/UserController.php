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
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    use Uploader;
    public function index()
    {
        return view('Front.User.Profile');
    }
    public function Wallet()
    {
        return view('Front.User.Wallet');
    }
    public function Show($UserID)
    {
        $User = TelegramUsers::find($UserID);
        return view('Front.User.ShowProfile')->with(['User' => $User]);
    }
    public function Update(Request $request)
    {
        $request->validate([
            'UserID' => 'required|numeric|exists:telegram_users,id',
            'UserName' => 'required|string|'.Rule::unique('telegram_users' , 'UserName')->ignore($request->UserID),
            'WalletAddress' => 'nullable|string|regex:/^(0x)?[0-9a-fA-F]{40}$/',

        ]);
        $User = TelegramUsers::where('id' , $request->UserID)->first();

        $User->update([
            'UserName' => $request->UserName,
            'WalletAddress' => $request->WalletAddress,
        ]);


        \Alert::success('Profile Updated successfully');

        return redirect()->back();
    }
    public function UpdatePlatform(Request $request)
    {
        $request->validate([
            'UserIDForPlato' => 'required|numeric|exists:telegram_users,id',
            'PlatoID' => 'required|string|'.Rule::unique('telegram_users' , 'PlatoID')->ignore($request->UserID),

        ]);
        $User = TelegramUsers::where('id' , $request->UserIDForPlato)->first();

        $User->update([
            'PlatoID' => $request->PlatoID,
        ]);


        \Alert::success('Platforms Updated successfully');

        return redirect()->back();
    }


}
