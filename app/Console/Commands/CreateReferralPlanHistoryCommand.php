<?php

namespace App\Console\Commands;

use App\Models\ReferralPlan;
use App\Models\ReferralPlanHistory;
use App\Models\TelegramUsers;
use App\Models\UserPaymentHistory;
use Illuminate\Console\Command;

class CreateReferralPlanHistoryCommand extends Command
{
    protected $signature = 'ReferralPlan:CreateHistory';

    protected $description = 'Create referral plan history for users dont have it';

    public function handle(): void
    {
        $FakeUserIds = TelegramUsers::where('UserName' , 'like' , '%KryptoArenaFreePosition%')->pluck('id')->toArray();
        $Users = TelegramUsers::whereNotIn('id', $FakeUserIds)->get();
        foreach ($Users as $User) {
            $ReferralCount = $User->Referrals()->count();
            $ReferralCounted = 0;
            $ReferralPlans = ReferralPlan::all();
            $LastPlan = null;
            foreach ($ReferralPlans as $referralplan) {
                $ReferralRemain = $ReferralCount - $ReferralCounted;
                if($ReferralRemain >= $referralplan->Count){
                    $ReferralCounted += $referralplan->Count;
                    $LastPlan = $referralplan->id;
                }
            }

            if($LastPlan != null){
                $Plans = ReferralPlan::where('id', '<=' , $LastPlan)->get();
                foreach ($Plans as $plan) {

                    $CheckReferralPlan = ReferralPlanHistory::where('UserID' , $User->id)->where('ReferralPlanID' , $plan->id)->count();
                    if($CheckReferralPlan == 0){
                        UserPaymentHistory::create([
                            'UserID' => $User->id,
                            'Description' => "Referral Plan Reward : {$plan->Name}",
                            'Amount' => $plan->Award,
                            'Type' => 'In',
                        ]);



                        $ReferralPlanHistory = ReferralPlanHistory::create([
                            'ReferralPlanID' => $plan->id,
                            'UserID' => $User->id,
                        ]);
                    }

                }
            }
        }
    }
}
