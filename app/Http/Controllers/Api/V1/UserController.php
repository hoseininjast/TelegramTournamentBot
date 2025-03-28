<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\Uploader;
use App\Models\Games;
use App\Models\ReferralPlan;
use App\Models\ReferralPlanHistory;
use App\Models\TelegramUserRewards;
use App\Models\TelegramUsers;
use App\Models\UserPaymentHistory;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Telegram\Bot\Api;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class UserController extends Controller
{
    public function Find($UserID)
    {
        $User = TelegramUsers::where('TelegramUserID', $UserID)->first();

        $ReferralUsers = TelegramUsers::where('ReferralID' , $User->id)->get();
        $ReferralCount = $ReferralUsers->count();
        $ReferralIncome = $ReferralCount * 0.01;

        $TournamentsJoined = $User->Tournaments()->count();
        $TournamentsWinned = $User->TournamentsWon()->count();

        return response()->json([
            'Data' => [
                'User' => $User,
                'ReferralUsers' => $ReferralUsers,
                'ReferralCount' => $ReferralCount,
                'ReferralIncome' => $ReferralIncome,
                'TournamentsJoined' => $TournamentsJoined,
                'TournamentsWinned' => $TournamentsWinned,
            ],
        ] , 200);
    }
    public function FindOrCreate(Request $request)
    {
        $request->validate([
            'TelegramData' => 'required|array',
            'ReferralID' => 'nullable|numeric|exists:telegram_users,TelegramUserID',
        ]);


        if(TelegramUsers::where('TelegramUserID', $request->TelegramData['id'])->count() > 0){
            $User = TelegramUsers::where('TelegramUserID', $request->TelegramData['id'])->first();
        }else{
            $User = TelegramUsers::create([
                'TelegramUserID' => $request->TelegramData['id'],
                'TelegramChatID' => $request->TelegramData['id'],
                'FirstName' => $request->TelegramData['first_name'] ,
                'LastName' => $request->TelegramData['last_name'] ,
                'UserName' => $request->TelegramData['username'] ,
                'Image' => $request->TelegramData['photo_url'] ,
            ]);

            if ($request->ReferralID){
                $RefferalUser = TelegramUsers::where('TelegramUserID' , $request->ReferralID)->first();
                if($User->ReferralID == null && $RefferalUser->id != $User->id){
                    $User->update([
                        'ReferralID' => $RefferalUser->id
                    ]);

                    $ReferralPlanHistoryCount = ReferralPlanHistory::where('UserID' , $RefferalUser->id)->count();
                    if($ReferralPlanHistoryCount == 0){
                        $FirstStage = ReferralPlan::first();
                        if ($RefferalUser->Referrals()->count() >= $FirstStage->Count){


                            $RefferalUser->update([
                                'Charge' => $RefferalUser->Charge + $FirstStage->Award
                            ]);

                            UserPaymentHistory::create([
                                'UserID' => $RefferalUser->id,
                                'Description' => "Referral Plan Reward : {$FirstStage->Name}",
                                'Amount' => $FirstStage->Award,
                                'Type' => 'In',
                            ]);

                            $ReferralPlanHistory = ReferralPlanHistory::create([
                                'ReferralPlanID' => $FirstStage->id,
                                'UserID' => $RefferalUser->id,
                            ]);


                        }
                    }else{
                        $LastStage = ReferralPlanHistory::where('UserID' , $RefferalUser->id)->latest()->first();
                        $Stages = $RefferalUser->ReferralPlanHistory;
                        $ReferralPlanCounted = 0;
                        foreach ($Stages as $stage) {
                            $ReferralPlanCounted += $stage->ReferralPlan->Count;
                        }
                        $ReferralsCount = $RefferalUser->Referrals()->count() ;
                        $NewReferrals = $ReferralsCount - $ReferralPlanCounted;
                        $NextStage = ReferralPlan::where('Level' , '>' , $LastStage->ReferralPlan->Level)->first();
                        if($NewReferrals >= $NextStage->Count){

                            $CheckReferralPlan = ReferralPlanHistory::where('UserID' , $RefferalUser->id)->where('ReferralPlanID' , $NextStage->id)->count();
                            if($CheckReferralPlan == 0){
                                $RefferalUser->update([
                                    'Charge' => $RefferalUser->Charge + $NextStage->Award
                                ]);

                                UserPaymentHistory::create([
                                    'UserID' => $RefferalUser->id,
                                    'Description' => "Referral Plan Reward : {$NextStage->Name}",
                                    'Amount' => $NextStage->Award,
                                    'Type' => 'In',
                                ]);



                                $ReferralPlanHistory = ReferralPlanHistory::create([
                                    'ReferralPlanID' => $NextStage->id,
                                    'UserID' => $RefferalUser->id,
                                ]);
                            }


                        }

                    }



                    $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
                    $inlineLayout = [
                        [
                            Keyboard::inlineButton(['text' => 'ورود به صفحه اصلی' , 'callback_data' => 'صفحه اصلی' ])
                        ],
                    ];

                    $telegram->sendPhoto([
                        'chat_id' => $RefferalUser->TelegramUserID,
                        'photo' => InputFile::create(public_path('images/Robot/Main.png')),
                        'caption' => "بازیکن جدیدی با لینک شما ثبت نام کرده است. ",
                        'parse_mode' => 'html',
                        'reply_markup' => json_encode([
                            'inline_keyboard' => $inlineLayout,
                            'resize_keyboard' => true,
                            'one_time_keyboard' => true
                        ])
                    ]);
                }
            }


        }
        return response()->json([
            'Data' => [
                'User' => $User,
            ],
        ] , 200);
    }


}
