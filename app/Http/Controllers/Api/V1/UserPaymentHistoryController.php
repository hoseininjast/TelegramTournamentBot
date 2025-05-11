<?php

namespace App\Http\Controllers\Api\V1;

use App\Classes\NowPayment;
use App\Http\Controllers\Controller;
use App\Models\Payments;
use App\Models\TelegramUsers;
use App\Models\UserPaymentHistory;
use Illuminate\Http\Request;

class UserPaymentHistoryController extends Controller
{
    public function List(Request $request){
        $request->validate([
            'UserID' => 'required|int|exists:telegram_users,id'
        ]);

        $User = TelegramUsers::find($request->UserID);
        $History = UserPaymentHistory::where('UserID' , $User->id)->get();

        return response()->json([
            'Data' => [
                'History' => $History,
                'Code' => 200,
            ],
        ], 200);

    }
}
