<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\Uploader;
use App\Models\Games;
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
                    TelegramUserRewards::create([
                        'UserID' => $RefferalUser->id,
                        'FromID' => $User->id,
                        'Amount' => 0.01 ,
                    ]);

                    $RefferalUser->update([
                        'Charge' => $RefferalUser->Charge + 0.01
                    ]);

                    UserPaymentHistory::create([
                        'UserID' => $RefferalUser->id,
                        'Description' => 'Referral Bonus',
                        'Amount' => 0.01,
                        'Type' => 'In',
                    ]);
                    $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
                    $inlineLayout = [
                        [
                            Keyboard::inlineButton(['text' => 'ورود به صفحه اصلی' , 'callback_data' => 'صفحه اصلی' ])
                        ],
                    ];

                    $telegram->sendPhoto([
                        'chat_id' => $RefferalUser->TelegramChatID,
                        'photo' => InputFile::create(public_path('images/Robot/Main.png')),
                        'caption' => "بازیکن جدیدی با لینک شما ثبت نام کرده است و جایزه معرفی آن به حساب شما واریز شده است.\n موجودی کیف پول : {$RefferalUser->Charge} دلار ",
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
