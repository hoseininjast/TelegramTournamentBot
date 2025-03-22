<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ReferralPlan;
use App\Models\ReferralPlanHistory;
use App\Models\TelegramUsers;
use Illuminate\Http\Request;

class ReferralPlanController extends Controller
{
    public function List()
    {
        $ReferralPlans = ReferralPlan::all();

        return response()->json([
            'Data' => [
                'ReferralPlans' => $ReferralPlans,
                'Code' => 200,
            ],
        ], 200);
    }
    public function Check(Request $request)
    {
        $request->validate([
            'ReferralPlanID' => 'required|integer|exists:referral_plans,id',
            'UserID' => 'required|integer|exists:telegram_users,id',
        ]);

        $ReferralPlans = ReferralPlan::find($request->ReferralPlanID);
        $User = TelegramUsers::find($request->UserID);

        $ReferralPlanHistory = ReferralPlanHistory::where([
            ['ReferralPlanID' , $ReferralPlans->id],
            ['UserID' , $User->id],
        ])->count();

        if ($ReferralPlanHistory > 0) {
            return response()->json([
                'Data' => [
                    'Status' => true,
                    'Code' => 200,
                ],
            ], 200);
        }else{
            return response()->json([
                'Data' => [
                    'Status' => false,
                    'Code' => 400,
                ],
            ], 200);
        }


    }
}
