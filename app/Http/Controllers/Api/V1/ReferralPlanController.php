<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ReferralPlan;

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
}
