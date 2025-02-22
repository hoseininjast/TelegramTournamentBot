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
        return response()->json([
            'Data' => [
                'User' => $User,
            ],
        ] , 200);
    }


}
