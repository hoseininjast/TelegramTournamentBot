<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Jobs\WithdrawUSDTJob;
use App\Models\TelegramUsers;
use App\Models\Withdraws;
use Carbon\Carbon;
use Illuminate\Http\Request;


class WithdrawController extends Controller
{
    public function Create(Request $request)
    {
        $request->validate([
            'Amount' => 'required|numeric|min:1',
            'PayingAddress' => 'required|string|regex:/^(0x)?(?i:[0-9a-f]){40}$/',
            'UserID' => 'required|integer|exists:telegram_users,id',
        ]);





        $User = TelegramUsers::find($request->UserID);

        if ($User->KAT == 0){
            return response()->json([
                'Data' => [
                    'Message' => 'Your account balance is 0 and you cannot withdraw.',
                    'Code' => 300,
                ],
            ] , 200);
        }else{
            if($User->KAT >= $request->Amount){
                $User->update([
                    'KAT' => $User->KAT - $request->Amount,
                ]);

                $Withdraw = Withdraws::create([
                    'WithdrawID' => 'KAW' . rand(10000000, 99999999),
                    'Amount' => $request->Amount,
                    'PayingAddress' => $request->PayingAddress,
                    'UserTransactionHash' => null,
                    'Status' => 'Pending',
                    'UserID' => $User->id,
                ]);

                WithdrawUSDTJob::dispatch($Withdraw->id);

                return response()->json([
                    'Data' => [
                        'Message' => 'Withdraw request submitted successfully',
                        'Code' => 200,
                    ],
                ] , 200);
            }else{
                return response()->json([
                    'Data' => [
                        'Message' => 'The requested amount is greater than your account balance, please try again.',
                        'Code' => 400,
                    ],
                ] , 200);
            }

        }





    }
}
