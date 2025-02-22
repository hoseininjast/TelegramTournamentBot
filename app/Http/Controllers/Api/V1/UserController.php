<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\Uploader;
use App\Models\Games;
use App\Models\TelegramUsers;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function Find($UserID)
    {
        $User = TelegramUsers::where('TelegramUserID', $UserID)->first();
        $ReferralCount = TelegramUsers::where('ReferralID' , $User->id)->count();
        $TournamentsJoined = $User->Tournaments()->count();
        $TournamentsWinned = $User->TournamentsWon()->count();
        return response()->json([
            'Data' => [
                'User' => $User,
                'ReferralCount' => $ReferralCount,
                'TournamentsJoined' => $TournamentsJoined,
                'TournamentsWinned' => $TournamentsWinned,
            ],
        ] , 200);
    }
    public function FindOrCreate(Request $request)
    {
        $request->validate([
            'TelegramData' => 'required|array',
        ]);


        return $request->TelegramData;
        if(TelegramUsers::where('TelegramUserID', $request->TelegramData['id'])->count() > 0){
            $User = TelegramUsers::where('TelegramUserID', $request->TelegramData['id'])->first();
        }else{
            $User = TelegramUsers::create([
                'TelegramUserID' => $request->TelegramData['id'],
                'TelegramChatID' => $request->TelegramData['id'],
                'FirstName' => $request->TelegramData[''] ,
                'LastName' => $this->GetUserInfo('last_name') ,
                'UserName' => $this->GetUserInfo('username') ,
            ]);
        }
        return $request->TelegramData['id'] ;
        $User = TelegramUsers::where('TelegramUserID', $UserID)->first();
        $ReferralCount = TelegramUsers::where('ReferralID' , $User->id)->count();
        $TournamentsJoined = $User->Tournaments()->count();
        $TournamentsWinned = $User->TournamentsWon()->count();
        return response()->json([
            'Data' => [
                'User' => $User,
                'ReferralCount' => $ReferralCount,
                'TournamentsJoined' => $TournamentsJoined,
                'TournamentsWinned' => $TournamentsWinned,
            ],
        ] , 200);
    }


}
