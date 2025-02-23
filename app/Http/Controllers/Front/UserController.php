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
    public function Show($UserID)
    {
        $User = TelegramUsers::find($UserID);
        return view('Front.User.Profile')->with(['User' => $User]);
    }
    public function Update(Request $request)
    {
        $request->validate([
            'UserID' => 'required|numeric|exists:telegram_users,id',
            'UserName' => 'required|string|'.Rule::unique('telegram_users' , 'UserName')->ignore($request->UserID),
            'PlatoID' => 'required|string|'.Rule::unique('telegram_users' , 'PlatoID')->ignore($request->UserID),
            'Image' => 'nullable|file|image',

        ]);
        $User = TelegramUsers::where('id' , $request->UserID)->first();
        if($request->hasFile('Image')){
            $AttachmentAddress = $this->UploadImage($request->Image , 'Profile');
        }else{
            $AttachmentAddress = $User->Image;
        }
        $User->update([
            'UserName' => $request->UserName,
            'PlatoID' => $request->PlatoID,
            'Image' => $AttachmentAddress,
        ]);


        \Alert::success('Profile Updated successfully');

        return redirect()->back();
    }


}
