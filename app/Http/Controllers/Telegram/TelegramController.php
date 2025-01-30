<?php

namespace App\Http\Controllers\Telegram;

use App\Classes\Number2Word;
use App\Http\Controllers\Controller;
use App\Http\Traits\CryptoTools;
use App\Models\Games;
use App\Models\Payments;
use App\Models\TelegramUserRewards;
use App\Models\TelegramUsers;
use App\Models\TournamentHistory;
use App\Models\Tournaments;
use App\Models\UserPaymentHistory;
use App\Models\UserTournaments;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Actions;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{

    use CryptoTools;
    protected  $Data ;
    protected $ChatID;
    protected $MessageID;
    protected $updates;
    protected $SiteSettings;

    protected $User;


    public function index(){
        $updates = Telegram::getWebhookUpdate();
        $this->updates = $updates;
        $this->ChatID = $updates->getChat()->getId();
        $this->Data = json_decode($updates , true);

        $this->User = $this->SaveTelegramUser();


        $MainMenuKeyboard = [
            [
                Keyboard::inlineButton(['text' => '💎تاریخچه💎', 'callback_data' => 'تاریخچه']),
                Keyboard::inlineButton(['text' => '💎تورنومنت ها💎', 'callback_data' => 'تورنومنت ها']),
            ],
            [
                Keyboard::inlineButton(['text' => 'تورنومنت های من', 'callback_data' => 'تورنومنت های من']),
                Keyboard::inlineButton(['text' => 'حساب کاربری', 'callback_data' => 'حساب کاربری من']),
            ],
            [
                Keyboard::inlineButton(['text' => 'کانال ما', 'url' => 'https://t.me/krypto_arena']),
            ],
        ];

        if ($updates->isType('callback_query') ){


            if ($this->Data['callback_query']['data'] == 'صفحه اصلی'){
                $this->EditMessage("💎سلام به ربات Krypto Arena خوش آمدید💎 \nلطفا از گزینه های زیر یکی رو انتخاب کنید" , $MainMenuKeyboard , 'https://kryptoarena.fun/images/Robot/Main.png');
            }

            if ($this->Data['callback_query']['data'] == 'تورنومنت های من'){
                $Tournaments = $this->User->Tournaments;
                foreach ($Tournaments as $tournament) {
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => $tournament->Tournament->Name , 'callback_data' => 'MyTournament-' . $tournament->Tournament->id ]);
                }
                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'صفحه اصلی' ]);

                $text = "
لطفا تورنومنت مد نظر خود را انتخاب کنید.
                ";
                $this->EditMessage($text , $inlineLayout , 'https://kryptoarena.fun/images/Robot/MyTournaments.png');

            }

            if ($this->Data['callback_query']['data'] == 'حساب کاربری من'){
                $User = $this->SaveTelegramUser();
                $inlineLayout = [];
                if($User->PlatoID == null){
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'احراز هویت پلاتو', 'callback_data' => 'احراز هویت پلاتو']);
                }else{
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'عوض کردن آیدی پلاتو', 'callback_data' => 'احراز هویت پلاتو']);
                }
                if($User->WalletAddress == null){
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'اضافه کردن آدرس والت Polygon', 'callback_data' => 'اضافه کردن آدرس والت']);
                }else{
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'عوض کردن آدرس والت Polygon', 'callback_data' => 'اضافه کردن آدرس والت']);
                }
                if($User->TonWalletAddress == null){
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'اضافه کردن آدرس والت Ton', 'callback_data' => 'اضافه کردن آدرس والت TON']);
                }else{
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'عوض کردن آدرس والت Ton', 'callback_data' => 'اضافه کردن آدرس والت TON']);
                }
                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'شارژ کیف پول', 'callback_data' => 'شارژ کیف پول']);


                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'صفحه اصلی' ]);
                $PlatoID = $User->PlatoID ? $User->PlatoID : 'ثبت نشده';
                $WalletAddress = $User->WalletAddress ? $User->WalletAddress : 'ثبت نشده';
                $TonWalletAddress = $User->TonWalletAddress ? $User->TonWalletAddress : 'ثبت نشده';
                $TotalGame = $User->Tournaments()->count();
                $Wins = $User->TournamentsWon()->count();
                $ReferralCount = TelegramUsers::where('ReferralID' , $User->id)->count();
                $text = "
در این صفحه شما میتوانید اکانت خود را مدیریت کنید
شارژ کیف پول : $ {$User->Charge}
تعداد تورنومنت های شرکت کرده : {$TotalGame}
تعداد قهرمانی ها : {$Wins}
آیدی پلاتو : {$PlatoID}
آدرس والت شبکه Polygon : {$WalletAddress}
آدرس والت شبکه Ton : {$TonWalletAddress}
تعداد افراد معرفی شده : {$ReferralCount} نفر
لینک معرفی شما : https://t.me/krypto_arena_bot?start={$User->TelegramUserID}
برای مدیریت حساب خود از دکمه های زیر استفاده کنید.
";
                $this->EditMessage($text , $inlineLayout , 'https://kryptoarena.fun/images/Robot/MyAccount.png');
            }

            if ($this->Data['callback_query']['data'] == 'شارژ کیف پول'){

                $inlineLayout = [
                    [
                        Keyboard::inlineButton(['text' => 'شارژ با Polygon' , 'callback_data' => 'ChargeWith-Polygon' ]),
                        Keyboard::inlineButton(['text' => 'شارژ با Ton' , 'callback_data' => 'ChargeWith-Ton' ])
                    ],
                    [
                        Keyboard::inlineButton(['text' => 'شارژ با USDT(POS)' , 'callback_data' => 'ChargeWith-USDTPOS' ]),
                        Keyboard::inlineButton(['text' => 'شارژ با USDT(TON)' , 'callback_data' => 'ChargeWith-USDTTON' ])
                    ],
                    [
                        Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'حساب کاربری من' ])
                    ]
                ];

                $text = "
لطفا ارز مورد نظر خود را انتخاب کنید.
";

                $this->EditMessage($text , $inlineLayout , 'https://kryptoarena.fun/images/Robot/ChargeWallet.jpg');
            }

            if ($this->Data['callback_query']['data'] == 'احراز هویت پلاتو'){

                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'صفحه اصلی' ]);

                $text = "
لطفا آیدی پلاتو خود را برای ربات ارسال کنید
مانند : PlatoID-Username
اگر آیدی شما مثلا arezoo92 هستش باید برای ربات به صورت زیر ارسالش کنید
<code>PlatoID-</code>arezoo92
باز زدن روی نوشته پایین میتونید متن را کپی کنید
<code>PlatoID-</code>
پس از ارسال آیدی اکانت شما ثبت میشود و میتوانید در مسابقات شرکت کنید.
";

                $this->EditMessage($text , $inlineLayout , 'https://kryptoarena.fun/images/Robot/Plato.png');
            }

            if ($this->Data['callback_query']['data'] == 'اضافه کردن آدرس والت'){

                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'حساب کاربری من' ]);

                $text = "
لطفا آدرس والت شبکه polygon خود را برای ربات ارسال کنید
پس از ثبت آدرس والت اکانت شما ثبت میشود و میتوانید در مسابقات شرکت کنید.
";

                $this->EditMessage($text , $inlineLayout , 'https://kryptoarena.fun/images/Robot/WalletAddress.png');
            }

            if ($this->Data['callback_query']['data'] == 'اضافه کردن آدرس والت TON'){

                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'حساب کاربری من' ]);

                $text = "
لطفا آدرس والت شبکه Ton خود را برای ربات ارسال کنید
اول کلمه ی  زیر را بنویسید سپس ادرس والت را به ان اضافه کنید
Ton-{WalletAddress}
برای مثال
Ton-UQAlf5oyxlRyFNb_hk8czxMCZXeqXw24dseIodDwbC77EmZB
پس از ثبت آدرس والت اکانت شما ثبت میشود و میتوانید در مسابقات شرکت کنید.
";

                $this->EditMessage($text , $inlineLayout , 'https://kryptoarena.fun/images/Robot/WalletAddress.png');
            }

            if ($this->Data['callback_query']['data'] == 'تاریخچه'){

                $inlineLayout = [];
                $Games = Games::all();
                for ($i = 0; $i < $Games->count(); $i+= 3) {
                    $inlineLayout[] = [
                        Keyboard::inlineButton(['text' => $Games[$i + 2]->Name , 'callback_data' => 'FinishedTournamentList-' . $Games[$i + 2]->id ]),
                        Keyboard::inlineButton(['text' => $Games[$i + 1]->Name , 'callback_data' => 'FinishedTournamentList-' . $Games[$i + 1]->id ]),
                        Keyboard::inlineButton(['text' => $Games[$i]->Name , 'callback_data' => 'FinishedTournamentList-' . $Games[$i]->id ]),
                    ];
                }
                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'صفحه اصلی' ]);

                $text = 'لطفا نوع تورنومنت را انتخاب کنید.';

                $this->EditMessage($text , $inlineLayout , 'https://kryptoarena.fun/images/Robot/TournamentHistory.png');
            }

            if ($this->Data['callback_query']['data'] == 'تورنومنت ها'){

                $inlineLayout = [
                    [
                        Keyboard::inlineButton(['text' => 'رایگان', 'callback_data' => 'Free']),
                    ],
                    [
                        Keyboard::inlineButton(['text' => 'پولی', 'callback_data' => 'Paid']),
                    ],
                ];
                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'صفحه اصلی' ]);

                $text = 'لطفا نوع تورنومنت را انتخاب کنید.';

                $this->EditMessage($text , $inlineLayout , 'https://kryptoarena.fun/images/Robot/Tournaments.png');
            }

            if ($this->Data['callback_query']['data'] == 'Free'){

                $inlineLayout = [];
                $Games = Games::all();
                for ($i = 0; $i < $Games->count(); $i+= 3) {
                    $inlineLayout[] = [
                        Keyboard::inlineButton(['text' => $Games[$i + 2]->Name , 'callback_data' => 'FreeTournamentList-' . $Games[$i + 2]->id ]),
                        Keyboard::inlineButton(['text' => $Games[$i + 1]->Name , 'callback_data' => 'FreeTournamentList-' . $Games[$i + 1]->id ]),
                        Keyboard::inlineButton(['text' => $Games[$i]->Name , 'callback_data' => 'FreeTournamentList-' . $Games[$i]->id ]),
                    ];
                }

                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'تورنومنت ها' ]);

                $text = 'لطفا بازی را انتخاب کنید.';

                $this->EditMessage($text , $inlineLayout , 'https://kryptoarena.fun/images/Robot/FreeTournaments.png');
            }

            if ($this->Data['callback_query']['data'] == 'Paid'){

                $inlineLayout = [];
                $Games = Games::all();
                for ($i = 0; $i < $Games->count(); $i+= 3) {
                    $inlineLayout[] = [
                        Keyboard::inlineButton(['text' => $Games[$i + 2]->Name , 'callback_data' => 'PaidTournamentList-' . $Games[$i + 2]->id ]),
                        Keyboard::inlineButton(['text' => $Games[$i + 1]->Name , 'callback_data' => 'PaidTournamentList-' . $Games[$i + 1]->id ]),
                        Keyboard::inlineButton(['text' => $Games[$i]->Name , 'callback_data' => 'PaidTournamentList-' . $Games[$i]->id ]),
                    ];
                }
                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'تورنومنت ها' ]);

                $text = 'لطفا بازی را انتخاب کنید.';

                $this->EditMessage($text , $inlineLayout , 'https://kryptoarena.fun/images/Robot/PaidTournaments.png');
            }


            if (preg_match('/^FreeTournamentList-/' , $this->Data['callback_query']['data'])){
                $GameID = preg_replace("/^FreeTournamentList-/", "", $this->Data['callback_query']['data']);

                $inlineLayout = [];
                $Game = Games::find($GameID);
                $Tournaments = Tournaments::where('GameID' , $Game->id)->where('Mode' , 'Free')->where('Status' , 'Pending')->get();
                foreach ($Tournaments as $tournament) {
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => $tournament->Name , 'callback_data' => 'Tournament-' . $tournament->id ]);
                }
                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'Free' ]);

                $text = "
لطفا تورنومنت مد نظر خود را انتخاب کنید.
                ";
                $this->EditMessage($text , $inlineLayout , $Game->Image);

            }

            if (preg_match('/^PaidTournamentList-/' , $this->Data['callback_query']['data'])){
                $GameID = preg_replace("/^PaidTournamentList-/", "", $this->Data['callback_query']['data']);

                $inlineLayout = [];
                $Game = Games::find($GameID);
                $Tournaments = Tournaments::where('GameID' , $Game->id)->where('Mode' , 'Paid')->where('Status' , 'Pending')->get();
                foreach ($Tournaments as $tournament) {
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => $tournament->Name , 'callback_data' => 'Tournament-' . $tournament->id ]);
                }
                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'Paid' ]);

                $text = "
لطفا تورنومنت مد نظر خود را انتخاب کنید.
                ";
                $this->EditMessage($text , $inlineLayout , $Game->Image);

            }

            if (preg_match('/^FinishedTournamentList-/' , $this->Data['callback_query']['data'])){
                $GameID = preg_replace("/^FinishedTournamentList-/", "", $this->Data['callback_query']['data']);

                $inlineLayout = [];
                $Game = Games::find($GameID);
                $Tournaments = Tournaments::where('GameID' , $Game->id)->where('Status' , '!=' ,'Pending')->get();
                foreach ($Tournaments as $tournament) {
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => $tournament->Name , 'callback_data' => 'TournamentHistory-' . $tournament->id ]);
                }
                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'تاریخچه' ]);

                $text = "
لطفا تورنومنت مد نظر خود را انتخاب کنید.
                ";
                $this->EditMessage($text , $inlineLayout , $Game->Image);

            }

            if (preg_match('/^Tournament-/' , $this->Data['callback_query']['data'])){
                $TournamentID = preg_replace("/^Tournament-/", "", $this->Data['callback_query']['data']);

                $inlineLayout = [];
                $Tournaments = Tournaments::find($TournamentID);
                $Status = __('messages.Status.' . $Tournaments->Status);
                $Mode = __('messages.Mode.' . $Tournaments->Mode);
                $Type = __('messages.Type.' . $Tournaments->Type);
                $adwards = '';
                foreach ($Tournaments->Awards as $key => $award) {
                    $adwards .= 'نفر ' . $key + 1 . ' = $' .$award ."\n";
                }

                $JalaliDate1 = Verta($Tournaments->Start)->format('%A, %d %B  H:i ');
                $JalaliDate2 = Verta($Tournaments->End)->format('%A, %d %B  H:i ');
                $GamesCount = $Tournaments->PlayerCount - 1;

                $text = "
نام : {$Tournaments->Name}
توضیحات : {$Tournaments->Description}
نوع : {$Type}
حالت : {$Mode}
 مبلغ ورودی : $ {$Tournaments->Price}
تعداد بازیکن : {$Tournaments->PlayerCount}
زمان بازی : {$Tournaments->Time} روز
تاریخ شروع : {$JalaliDate1}
تاریخ پایان : {$JalaliDate2}
مراحل : {$Tournaments->TotalStage} مرحله
تعداد بازی : {$GamesCount} بازی
تعداد برندگان : {$Tournaments->Winners}
جوایز : \n {$adwards}
وضعیت : {$Status}
                ";

                if(!$Tournaments->isJoined($this->User->id)){
                    if($this->User->PlatoID){
                        $inlineLayout[][] = Keyboard::inlineButton(['text' => 'ثبت نام در تورنومنت' , 'callback_data' => 'JoinTournament-'.$Tournaments->id ]);
                    }else{
                        $inlineLayout[][] = Keyboard::inlineButton(['text' => 'احراز هویت پلاتو', 'callback_data' => 'احراز هویت پلاتو']);
                    }
                }else{
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'دیدن برنامه بازی ها' , 'callback_data' => 'MyTournament-'.$Tournaments->id ]);
                }


                if($Tournaments->Mode == 'Free'){
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'FreeTournamentList-' . $Tournaments->Game->id ]);
                }else{
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'PaidTournamentList-' . $Tournaments->Game->id ]);
                }

                $this->EditMessage($text , $inlineLayout , $Tournaments->GetImage());

            }

            if (preg_match('/^TournamentHistory-/' , $this->Data['callback_query']['data'])){
                $TournamentID = preg_replace("/^TournamentHistory-/", "", $this->Data['callback_query']['data']);

                $inlineLayout = [];
                $Tournaments = Tournaments::find($TournamentID);
                $Status = __('messages.Status.' . $Tournaments->Status);
                $Mode = __('messages.Mode.' . $Tournaments->Mode);
                $Type = __('messages.Type.' . $Tournaments->Type);

                $JalaliDate1 = Verta($Tournaments->Start)->format('%A, %d %B  H:i ');
                $JalaliDate2 = Verta($Tournaments->End)->format('%A, %d %B  H:i ');
                $GamesCount = $Tournaments->PlayerCount - 1;




                if($Tournaments->Status == 'Running'){
                    for ($i = 1 ; $i <= $Tournaments->TotalStage ; $i++){
                        $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله ' . $this->numToWordForStages($i) , 'callback_data' => 'ShowTournamentPlan' . $Tournaments->id . ' Stage'.$i ]);
                    }
                    $text = "
نام : {$Tournaments->Name}
توضیحات : {$Tournaments->Description}
نوع : {$Type}
حالت : {$Mode}
 مبلغ ورودی : $ {$Tournaments->Price}
تعداد بازیکن : {$Tournaments->PlayerCount}
زمان بازی : {$Tournaments->Time} روز
تاریخ شروع : {$JalaliDate1}
تاریخ پایان : {$JalaliDate2}
وضعیت : {$Status}
";

                }
                elseif($Tournaments->Status == 'Finished'){
                    for ($i = 1 ; $i <= $Tournaments->TotalStage ; $i++){
                        $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله ' . $this->numToWordForStages($i) , 'callback_data' => 'ShowTournamentPlan' . $Tournaments->id . ' Stage'.$i ]);
                    }
                    $Winners = '';
                    foreach ($Tournaments->History->Winners as $key => $playerid) {
                        $User = TelegramUsers::find($playerid);
                        $Winners .= "نفر ". $this->numToWordForStages($key) ." : ". $User->PlatoID ." => $". $Tournaments->Awards[$key - 1 ] ." \n";
                    }

                    $text = "
نام : {$Tournaments->Name}
توضیحات : {$Tournaments->Description}
نوع : {$Type}
حالت : {$Mode}
 مبلغ ورودی : $ {$Tournaments->Price}
تعداد بازیکن : {$Tournaments->PlayerCount}
زمان بازی : {$Tournaments->Time} روز
تاریخ شروع : {$JalaliDate1}
تاریخ پایان : {$JalaliDate2}
نتیجه بازی :
{$Winners}
وضعیت : {$Status}
";

                }



                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'FinishedTournamentList-' . $Tournaments->Game->id ]);


                $this->EditMessage($text , $inlineLayout , $Tournaments->GetImage());

            }

            if (preg_match('/^MyTournament-/' , $this->Data['callback_query']['data'])){
                $TournamentID = preg_replace("/^MyTournament-/", "", $this->Data['callback_query']['data']);

                $inlineLayout = [];
                $Tournaments = Tournaments::find($TournamentID);

                $Status = __('messages.Status.' . $Tournaments->Status);
                $Mode = __('messages.Mode.' . $Tournaments->Mode);
                $Type = __('messages.Type.' . $Tournaments->Type);

                $JalaliDate1 = Verta($Tournaments->Start)->format('%A, %d %B  H:i ');
                $JalaliDate2 = Verta($Tournaments->End)->format('%A, %d %B  H:i ');
                $GamesCount = $Tournaments->PlayerCount - 1;


                if ($Tournaments->Status == 'Pending'){
                    $text = "
نام : {$Tournaments->Name}
توضیحات : {$Tournaments->Description}
نوع : {$Type}
حالت : {$Mode}
 مبلغ ورودی : $ {$Tournaments->Price}
تعداد بازیکن : {$Tournaments->PlayerCount}
زمان بازی : {$Tournaments->Time} روز
تاریخ شروع : {$JalaliDate1}
تاریخ پایان : {$JalaliDate2}
مراحل : {$Tournaments->TotalStage} مرحله
تعداد بازی : {$GamesCount} بازی
وضعیت : {$Status}
";
                }
                elseif($Tournaments->Status == 'Running'){
                    for ($i = 1 ; $i <= $Tournaments->TotalStage ; $i++){
                        $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله ' . $this->numToWordForStages($i) , 'callback_data' => 'ShowTournamentPlan' . $Tournaments->id . ' Stage'.$i ]);
                    }
                    $text = "
نام : {$Tournaments->Name}
توضیحات : {$Tournaments->Description}
نوع : {$Type}
حالت : {$Mode}
 مبلغ ورودی : $ {$Tournaments->Price}
تعداد بازیکن : {$Tournaments->PlayerCount}
زمان بازی : {$Tournaments->Time} روز
تاریخ شروع : {$JalaliDate1}
تاریخ پایان : {$JalaliDate2}
وضعیت : {$Status}
";

                }
                elseif($Tournaments->Status == 'Finished'){
                    for ($i = 1 ; $i <= $Tournaments->TotalStage ; $i++){
                        $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله ' . $this->numToWordForStages($i) , 'callback_data' => 'ShowTournamentPlan' . $Tournaments->id . ' Stage'.$i ]);
                    }
                    $Winners = '';
                    foreach ($Tournaments->History->Winners as $key => $playerid) {
                        $User = TelegramUsers::find($playerid);
                        $Winners .= "نفر ". $this->numToWordForStages($key) ." : ". $User->PlatoID ." => $". $Tournaments->Awards[$key - 1 ] ." \n";
                    }

                    $text = "
نام : {$Tournaments->Name}
توضیحات : {$Tournaments->Description}
نوع : {$Type}
حالت : {$Mode}
 مبلغ ورودی : $ {$Tournaments->Price}
تعداد بازیکن : {$Tournaments->PlayerCount}
زمان بازی : {$Tournaments->Time} روز
تاریخ شروع : {$JalaliDate1}
تاریخ پایان : {$JalaliDate2}
نتیجه بازی :
{$Winners}
وضعیت : {$Status}
";

                }





                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'تورنومنت های من']);


                $this->EditMessage($text , $inlineLayout , $Tournaments->GetImage());

            }

            if(preg_match('/^ShowTournamentPlan\d+\sStage\d+$/' , $this->Data['callback_query']['data'])){


                $exp = explode(' ' , $this->Data['callback_query']['data']);
                $TournamentID = preg_replace("/^ShowTournamentPlan/", "", $exp[0]);
                $Stage = preg_replace("/^Stage/", "", $exp[1]);

                $inlineLayout = [];
                $Tournaments = Tournaments::find($TournamentID);

                $TournamentPlan = $Tournaments->Plans()->where('Stage' , $Stage)->get();
                $Stages = $Tournaments->StagesDate;
                $CurrentStageTime = $Stages[$Stage - 1 ];
                $CurrentStageTime = Verta($CurrentStageTime)->format('%A, %d %B  H:i ');
                if($Stage < $Tournaments->TotalStage){
                    $NextStageTime = Verta($Stages[$Stage])->format('%A, %d %B  H:i ');
                    $Pic = $Tournaments->GetImage();
                }else{
                    $NextStageTime = Verta($Tournaments->End)->format('%A, %d %B  H:i ');
                    if($Tournaments->History->Image != null){
                        $Pic = $Tournaments->History->Image;
                    }else{
                        $Pic = $Tournaments->GetImage();
                    }
                }

                $Games = '';
                $Games2 = '';
                if($TournamentPlan->count() < 9){
                    foreach ($TournamentPlan as $plan) {
                        $Winner = $plan->WinnerID ? $plan->Winner->PlatoID : 'مشخص نشده';
                        $Time = Verta($plan->Time)->format('%A, %d %B  H:i ');
                        $Games .= "گروه {$this->numToWords($plan->Group)} : {$plan->Player1->PlatoID} --- {$plan->Player2->PlatoID} \n زمان : {$Time} \n برنده : {$Winner} \n";
                    }

                    if($TournamentPlan->count() > 0){

                        $text = "
برنامه بازی مرحله {$this->numToWordForStages($Stage)}
زمان شروع مرحله : {$CurrentStageTime}
زمان پایان مرحله : {$NextStageTime}
\nلیست بازی ها :
{$Games}
@krypto_arena_bot
";

                    }else{

                        $text = "
برنامه بازی مرحله {$this->numToWordForStages($Stage)}
زمان شروع مرحله : {$CurrentStageTime}
زمان پایان مرحله : {$NextStageTime}
هنوز لیست بازی ها مشخص نشده ، بعد از مشخص شدن میتوانید در همین صفحه ببینید.
@krypto_arena_bot
";

                    }


                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'MyTournament-' . $TournamentID]);


                    $this->EditMessage($text , $inlineLayout , $Pic);


                }else{
                    for ($i = 0; $i < 8; $i++) {
                        $plan = $TournamentPlan[$i];
                        $Winner = $plan->WinnerID ? $plan->Winner->PlatoID : 'مشخص نشده';
                        $Time = Verta($plan->Time)->format('%A, %d %B  H:i ');
                        $Games .= "گروه {$this->numToWords($plan->Group)} : {$plan->Player1->PlatoID} --- {$plan->Player2->PlatoID} \n زمان : {$Time} \n برنده : {$Winner} \n";
                    }

                    for ($i = 8; $i <= $TournamentPlan->count() - 1; $i++) {
                        $plan = $TournamentPlan[$i];
                        $Winner = $plan->WinnerID ? $plan->Winner->PlatoID : 'مشخص نشده';
                        $Time = Verta($plan->Time)->format('%A, %d %B  H:i ');
                        $Games2 .= "گروه {$this->numToWords($plan->Group)} : {$plan->Player1->PlatoID} --- {$plan->Player2->PlatoID} \n زمان : {$Time} \n برنده : {$Winner} \n";
                    }

                    if($TournamentPlan->count() > 0){

                        $text = "
برنامه بازی مرحله {$this->numToWordForStages($Stage)}
زمان شروع مرحله : {$CurrentStageTime}
زمان پایان مرحله : {$NextStageTime}
\nلیست بازی ها :
{$Games}
";
                        $text2 = "
{$Games2}
@krypto_arena_bot
                    ";

                    }else{

                        $text = "
برنامه بازی مرحله {$this->numToWordForStages($Stage)}
زمان شروع مرحله : {$CurrentStageTime}
زمان پایان مرحله : {$NextStageTime}
هنوز لیست بازی ها مشخص نشده ، بعد از مشخص شدن میتوانید در همین صفحه ببینید.
@krypto_arena_bot
";
                    }


                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'MyTournament-' . $TournamentID]);


                    $this->EditMessage($text , null , $Pic);
                    $this->Response($text2 , $inlineLayout );


                }








            }

            if (preg_match('/^JoinTournament-/' , $this->Data['callback_query']['data'])){
                $TournamentID = preg_replace("/^JoinTournament-/", "", $this->Data['callback_query']['data']);

                $inlineLayout = [];
                $Tournaments = Tournaments::find($TournamentID);

                $ChanelID = Telegram::getChat(['chat_id' => '@krypto_arena']);
                $JoinInfo = Telegram::getChatMember([
                    'chat_id' => $ChanelID['id'],
                    'user_id' => $this->GetUserInfo('id'),
                ]);
                if($JoinInfo['status'] == 'left' ){
                    $inlineLayout = [
                        [
                            Keyboard::inlineButton(['text' => 'عضویت در کانال', 'url' => 'https://t.me/krypto_arena']),
                        ],
                        [
                            Keyboard::inlineButton(['text' => 'بررسی عضویت', 'callback_data' => 'CheckMembership']),
                        ],
                    ];
                    $text = 'برای استفاده از این ربات باید در کانال ما عضو شوید ، بعد از عضویت میتوانید از تمام امکانات ربات استفاده کنید.';
                    $this->ResponseWithPhoto($text , $inlineLayout , 'https://kryptoarena.fun/images/Robot/Main.png');
                }else{
                    if ($Tournaments->Players()->count() < $Tournaments->PlayerCount){
                        if(!$Tournaments->isJoined($this->User->id)){
                            if($this->User->PlatoID){
                                if($Tournaments->Mode == 'Free'){
                                    UserTournaments::create([
                                        'UserID' => $this->User->id,
                                        'TournamentID' => $Tournaments->id,
                                    ]);
                                    $text = "شما با موفقیت وارد تورنومنت شدید. پس از قرعه کشی و مشخص شدن ترتیب بازی ها ، برنامه بازی ها به شما اطلاعات داده خواهد شد.";
                                }elseif($Tournaments->Mode == 'Paid'){

                                    if ($this->User->Charge >= $Tournaments->Price){
                                        $this->User->update([
                                            'Charge' => $this->User->Charge - $Tournaments->Price
                                        ]);
                                        UserPaymentHistory::create([
                                            'UserID' => $this->User->id,
                                            'Description' => 'Tournament joined',
                                            'Amount' => $Tournaments->Price,
                                            'Type' => 'Out',
                                        ]);
                                        UserTournaments::create([
                                            'UserID' => $this->User->id,
                                            'TournamentID' => $Tournaments->id,
                                        ]);
                                        $text = "شما با موفقیت وارد تورنومنت شدید. پس از قرعه کشی و مشخص شدن ترتیب بازی ها ، برنامه بازی ها به شما اطلاعات داده خواهد شد.";
                                    }else{
                                        $text = "کیف پول شما شارژ کافی برای عضو شدن در تورنومنت را ندارد ،‌لطفا کیف پول خود را شارژ کرده و سپس اقدام به عضویت کنید.";
                                        $inlineLayout[][] = Keyboard::inlineButton(['text' => 'شارژ کیف پول' , 'callback_data' => 'شارژ کیف پول'  ]);

                                    }
                                }
                            }else{
                                $text = "شما هنوز آیدی پلاتو خود را احراز نکرده اید ،‌پس از احراز هویت مجددا برای عضویت تلاش کنید.";
                            }

                        }
                        else{
                            $text = "شما قبلا در این تورنومنت شرکت کرده اید.";

                        }
                    }else{
                        $text = "متاسفانه تعداد بازی کنان این مسابفه تکیل شده است و شما نمیتوانید در آن شرکت کنید ، لطفا از منوی تورنومنت ها ،‌مسابقه دیگری را انتخاب کنید.";
                    }
                }




                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'صفحه اصلی' , 'callback_data' => 'صفحه اصلی'  ]);
                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'Tournament-' . $Tournaments->id  ]);


                $this->EditMessage($text , $inlineLayout , $Tournaments->GetImage());

            }

            if (preg_match('/^ChargeWith-/' , $this->Data['callback_query']['data'])){
                $TokenName = preg_replace("/^ChargeWith-/", "", $this->Data['callback_query']['data']);
                $inlineLayout = [
                    [
                        Keyboard::inlineButton(['text' => 'شارژ 1 دلار' , 'callback_data' => 'ChargeWith'. $TokenName .' Amount1'   ]),
                        Keyboard::inlineButton(['text' => 'شارژ 2 دلار' , 'callback_data' => 'ChargeWith'. $TokenName .' Amount2'   ]),
                    ],
                    [
                        Keyboard::inlineButton(['text' => 'شارژ 5 دلار' , 'callback_data' => 'ChargeWith'. $TokenName .' Amount5'   ]),
                        Keyboard::inlineButton(['text' => 'شارژ 10 دلار' , 'callback_data' => 'ChargeWith'. $TokenName .' Amount10'   ]),
                    ],
                    [
                        Keyboard::inlineButton(['text' => 'شارژ 20 دلار' , 'callback_data' => 'ChargeWith'. $TokenName .' Amount20'   ]),
                        Keyboard::inlineButton(['text' => 'شارژ 50 دلار' , 'callback_data' => 'ChargeWith'. $TokenName .' Amount50'   ]),
                    ],
                    [
                        Keyboard::inlineButton(['text' => 'شارژ 100 دلار' , 'callback_data' => 'ChargeWith'. $TokenName .' Amount100'   ]),
                    ],
                    [
                        Keyboard::inlineButton(['text' => 'مبالغ دیگر(به زودی)' , 'callback_data' => 'null'   ]),
                    ],
                    [
                        Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'شارژ کیف پول'  ])
                    ],
                ];

                $text = "
شارژ کیف پول
ارز انتخاب شده : {$TokenName}
لطفا مبلغ موردنظر خود را انتخاب کنید.
";

                $this->EditMessage($text , $inlineLayout , 'https://kryptoarena.fun/images/Robot/WalletAddress.png');

            }

            if(preg_match('/^ChargeWith(Polygon|Ton|USDTPOS|USDTTON)\sAmount\d+$/' , $this->Data['callback_query']['data']) == 1){

                $exp = explode(' ' , $this->Data['callback_query']['data']);
                $PaymentMethod = preg_replace("/^ChargeWith/", "", $exp[0]);
                $Amount = preg_replace("/^Amount/", "", $exp[1]);

                $inlineLayout = [];

                $PaymentDetail = $this->CreatePaymentOrder($PaymentMethod , $Amount);

                $User = $this->SaveTelegramUser();

                if($PaymentDetail){

                    $Payment = Payments::create([
                        'OrderID' => $PaymentDetail['order_id'],
                        'PaymentID' => $PaymentDetail['payment_id'],
                        'FiatAmount' => $PaymentDetail['price_amount'],
                        'CryptoAmount' => $PaymentDetail['pay_amount'],
                        'PaymentMethod' => $PaymentMethod,
                        'PayingAddress' => $PaymentDetail['pay_address'],
                        'Status' => 'Pending',
                        'UserID' => $User->id,
                    ]);

                    $PaymentID = $PaymentDetail['payment_id'];
                    $WalletAddress = $pay_address = $PaymentDetail['pay_address'];
                    $pay_amount = $PaymentDetail['pay_amount'];

                    if ($PaymentMethod == 'Polygon'){
                        $Pic = 'https://vpn.ai1polaris.com/images/New/Matic.png';
                        $PaymentAddress = "https://metamask.app.link/send/{$WalletAddress}@137?value=" . $pay_amount ."e18";
                        $inlineLayout[][] = Keyboard::inlineButton(['text' => 'پرداخت' , 'url' =>  $PaymentAddress]);
                        $inlineLayout[][] = Keyboard::inlineButton(['text' => 'بروزرسانی فاکتور' , 'callback_data' => 'CheckPaymentStatus-' .$Payment->id ]);
                    }
                    elseif ($PaymentMethod == 'USDTPOS'){
                        $Pic = 'https://vpn.ai1polaris.com/images/New/USDT.png';
                        $PayAmountForUSDT = preg_replace("/\./", "", round($pay_amount, 6 ,PHP_ROUND_HALF_UP) );
                        $PaymentAddress = "https://metamask.app.link/send/0xc2132D05D31c914a87C6611C10748AEb04B58e8F@137/transfer?address={$pay_address}&uint256={$PayAmountForUSDT}";
                        $inlineLayout[][] = Keyboard::inlineButton(['text' => 'پرداخت' , 'url' =>  $PaymentAddress]);
                        $inlineLayout[][] = Keyboard::inlineButton(['text' => 'بروزرسانی فاکتور' , 'callback_data' => 'CheckPaymentStatus-' .$Payment->id]);
                    }
                    elseif ($PaymentMethod == 'Ton'){
                        $Pic = 'https://vpn.ai1polaris.com/images/New/Ton.png';
                        $PayAmountForTon = preg_replace("/\./", "", $pay_amount);
                        $pay_amount_button = $PayAmountForTon . 0;
                        $PaymentAddress = "https://app.tonkeeper.com/transfer/{$WalletAddress}?amount={$pay_amount_button}";
                        $inlineLayout[][] = Keyboard::inlineButton(['text' => 'پرداخت' , 'url' =>  $PaymentAddress]);
                        $inlineLayout[][] = Keyboard::inlineButton(['text' => 'بروزرسانی فاکتور' , 'callback_data' => 'CheckPaymentStatus-' .$Payment->id  ]);
                    }
                    elseif ($PaymentMethod == 'USDTTON'){
                        $Pic = 'https://vpn.ai1polaris.com/images/New/USDTTON.png';
                        $inlineLayout[][] = Keyboard::inlineButton(['text' => 'بروزرسانی فاکتور' , 'callback_data' => 'CheckPaymentStatus-' .$Payment->id ]);
                    }

                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'ChargeWith-' . $PaymentMethod  ]);

                    $text = "
شارژ کیف پول
‼️پیش از‌ پرداخت ، لطفا تمامی بند ها را مطالعه کنید‼️
1⃣ مبلغ فاكتور شما به شرح زير ميباشد. لطفا در صورت تاييد روى دكمه پرداخت كليک كنيد.
2⃣ پس از پرداخت توسط والت به همين صفحه برگرديد و هر ٣٠ ثانيه روى دكمه بروزرسانى كليک كنيد تا مبلغ مورد نظر به کیف پول شما اضافه شود.
3⃣ در صورتي كه ديوايس شما اپديت نباشد، ميتوانيد مبلغ و ادرس مقصد را به صورت دستى و دقيق در والتتان وارد كرده و انتقال را انجام دهيد سپس به همين صفحه برگرديد و روي دكمه بروزرسانى كليک كنيد.
تا زمانی که ربات به شما پیام موفقیت آمیز بودن پرداخت را ندهد باید در این صفحه صبر کنید و بروزرسانی را بزنید.
" . PHP_EOL . "
💲 روش پرداخت :". $PaymentMethod . "
💲 مبلغ شارژ :". number_format($Amount ,2 ,'.' , ',') . " $
💸 مبلغ نهایی : 📑" . "<code><b>" . number_format($pay_amount ,6 ,'.' , ',') . "</b></code> " . $PaymentMethod ."📑
آدرس ولت : 📑<code>{$WalletAddress}</code>📑
";

                    $this->EditMessage($text ,$inlineLayout , $Pic);



                }else{
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'ChargeWith-' . $PaymentMethod  ]);
                    $text = "مشکلی در ساخت فاکتور پیش آمده لطفا بعدا دوباره تلاش کنید.";
                    $this->EditMessage($text ,$inlineLayout);

                }


            }

            if (preg_match('/^CheckPaymentStatus-/' , $this->Data['callback_query']['data']) == 1){

                $inlineLayout = [];

                $PaymentID = preg_replace("/^CheckPaymentStatus-/", "", $this->Data['callback_query']['data']);
                $Payment = Payments::find($PaymentID);

                $WalletAddress = $pay_address = $Payment->PayingAddress;
                $pay_amount = $Payment->CryptoAmount;
                $Amount = $Payment->FiatAmount;
                $PaymentMethod = $Payment->PaymentMethod;

                if ($PaymentMethod == 'Polygon'){
                    $Pic = 'https://vpn.ai1polaris.com/images/New/Matic.png';
                }
                elseif ($PaymentMethod == 'USDTPOS'){
                    $Pic = 'https://vpn.ai1polaris.com/images/New/USDT.png';
                }
                elseif ($PaymentMethod == 'Ton'){
                    $Pic = 'https://vpn.ai1polaris.com/images/New/Ton.png';
                }
                elseif ($PaymentMethod == 'USDTTON'){
                    $Pic = 'https://vpn.ai1polaris.com/images/New/USDTTON.png';
                }


                $Status = $this->CheckPaymentStatus($Payment);
                $Code = $Status['Code'];
                $Message = $Status['Message'];

                if ($Code == 4 || $Code == 5){
                    $text = "
{$Message}
با تشکر از خرید شما.";
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'حساب کاربری' , 'callback_data' => 'حساب کاربری' ]);

                    $this->EditMessage($text ,$inlineLayout , 'https://kryptoarena.fun/images/Robot/WalletAddress.png' );

                }else{

                    $text = "
‼️پیش از‌ پرداخت ، لطفا تمامی بند ها را مطالعه کنید‼️
1⃣ مبلغ فاكتور شما به شرح زير ميباشد. لطفا در صورت تاييد روى دكمه پرداخت كليک كنيد.
2⃣ پس از پرداخت توسط والت به همين صفحه برگرديد و هر ٣٠ ثانيه روى دكمه بروزرسانى كليک كنيد تا مبلغ مورد نظر به کیف پول شما اضافه شود.
3⃣ در صورتي كه ديوايس شما اپديت نباشد، ميتوانيد مبلغ و ادرس مقصد را به صورت دستى و دقيق در والتتان وارد كرده و انتقال را انجام دهيد سپس به همين صفحه برگرديد و روي دكمه بروزرسانى كليک كنيد.
تا زمانی که ربات به شما پیام موفقیت آمیز بودن پرداخت را ندهد باید در این صفحه صبر کنید و بروزرسانی را بزنید.
" . PHP_EOL . "
💲 روش پرداخت :". $PaymentMethod . "
💲 مبلغ شارژ :". number_format($Amount ,2 ,'.' , ',') . " $
💸 مبلغ نهایی : 📑" . "<code><b>" . number_format($pay_amount ,6 ,'.' , ',') . "</b></code> " . $PaymentMethod ."📑
آدرس ولت : 📑<code>{$WalletAddress}</code>📑


وضعیت فاکتور :
{$Message}
";


                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'بروزرسانی فاکتور' , 'callback_data' => 'CheckPaymentStatus-' .$Payment->id ]);
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'ChargeWith-' . $PaymentMethod  ]);
                    $this->EditMessage($text ,$inlineLayout , $Pic , 'photo');


                }






            }

            if ($this->Data['callback_query']['data'] == 'CheckMembership'){

                $ChanelID = Telegram::getChat(['chat_id' => '@krypto_arena']);
                $JoinInfo = Telegram::getChatMember([
                    'chat_id' => $ChanelID['id'],
                    'user_id' => $this->GetUserInfo('id'),
                ]);
                if($JoinInfo['status'] == 'member' || $JoinInfo['status'] == 'creator' || $JoinInfo['status'] == 'administrator' ){
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'صفحه اصلی' , 'callback_data' => 'صفحه اصلی' ]);

                    $text = 'با تشکر از عضویت شما در کانال ما ، ثبت نام شما با موفقیت انجام شد و هم اکنون میتوانید از تمام امکانات ربات استفاده کنید.';

                }else{
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'عضویت در کانال' , 'url' => 'https://t.me/krypto_arena' ]);
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'بررسی مجدد' , 'callback_data' => 'CheckMembership' ]);

                    $text = 'شما در کانال ما عضو نیستید ، لطفا پس از عوضیت مجدد تلاش کنید.';

                }



                $this->EditMessage($text , $inlineLayout , 'https://kryptoarena.fun/images/Robot/Main.png');
            }



        }
        elseif ($updates->isType('message') ){
            if (isset($this->Data['message']['text'])){

                if ($this->Data['message']['text'] == '/start' || $this->Data['message']['text'] == 'start'){
                    $this->ResponseWithPhoto("🌠💸🤝سلام به ربات Krypto Arena خوش آمدید\nلطفا از گزینه های زیر یکی رو انتخاب کنید🤝💸🌠" , $MainMenuKeyboard , 'https://kryptoarena.fun/images/Robot/Main.png' );
                }

                if (preg_match('/\/start\s([0-9]+)/' , $this->Data['message']['text']) ){
                    $ReferralID = preg_replace("/\/start\s/", "", $this->Data['message']['text']);
                    $RefferalUser = TelegramUsers::where('TelegramUserID' , $ReferralID)->first();

                    $inlineLayout = [
                        [
                            Keyboard::inlineButton(['text' => 'ورود به صفحه اصلی' , 'callback_data' => 'صفحه اصلی' ])
                        ],
                    ];

                    if ($RefferalUser) {
                        $User = $this->SaveTelegramUser();

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

                            $this->ResponseWithPhoto("بازیکن جدیدی با لینک شما ثبت نام کرده است و جایزه معرفی آن به حساب شما واریز شده است.\n موجودی کیف پول : {$RefferalUser->Charge} دلار " ,$inlineLayout , 'https://kryptoarena.fun/images/Robot/Main.png' ,$RefferalUser->TelegramUserID);
                            $text = "معرف شما ثبت شد و هم اکنون تمام امکانات ربات برای شما در دسترس میباشد. ";

                        }else{
                            $text = "شما قبلا معرف خود را وارد کرده اید.";
                        }
                    }else{
                        $text = "لینک معرفی شما درست نمیباشد. لطفا مجدد تلاش کنید.";
                    }



                    $this->ResponseWithPhoto($text , $inlineLayout , 'https://kryptoarena.fun/images/Robot/Main.png' );
                }

                if ($this->Data['message']['text'] == '/tournaments' || $this->Data['message']['text'] == 'tournaments'){
                    $inlineLayout = [
                        [
                            Keyboard::inlineButton(['text' => 'رایگان', 'callback_data' => 'Free']),
                        ],
                        [
                            Keyboard::inlineButton(['text' => 'پولی', 'callback_data' => 'null']),
                        ],
                    ];
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'صفحه اصلی' ]);

                    $text = 'لطفا نوع تورنومنت را انتخاب کنید.';

                    $this->ResponseWithPhoto($text , $inlineLayout  , 'https://kryptoarena.fun/images/Robot/Tournaments.png');
                }

                if (preg_match('/^PlatoID-/' , $this->Data['message']['text'])){
                    $PlatoID = preg_replace("/^PlatoID-/", "", $this->Data['message']['text']);

                    $inlineLayout = [];

                    $User = $this->SaveTelegramUser();
                    $User->update([
                        'PlatoID' => $PlatoID
                    ]);
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'حساب کاربری من' , 'callback_data' => 'حساب کاربری من' ]);

                    $text = "
اکانت پلاتو شما ثبت شد.
هم اکنون میتوانید در مسابقات شرکت کنید و کیف پول خود را شارژ کنید.
                ";
                    $this->ResponseWithPhoto($text , $inlineLayout, 'https://kryptoarena.fun/images/Robot/Plato.png' );

                }

                if (preg_match('/^Ton-/' , $this->Data['message']['text'])){
                    $WalletAddress = preg_replace("/^Ton-/", "", $this->Data['message']['text']);

                    $inlineLayout = [];

                    $User = $this->SaveTelegramUser();
                    $User->update([
                        'TonWalletAddress' => $WalletAddress
                    ]);
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'حساب کاربری من' , 'callback_data' => 'حساب کاربری من' ]);

                    $text = "
آدرس والت شبکه تون شما ثبت شد.
هم اکنون میتوانید در مسابقات شرکت کنید و کیف پول خود را شارژ کنید.
                ";
                    $this->ResponseWithPhoto($text , $inlineLayout, 'https://kryptoarena.fun/images/Robot/WalletAddress.png' );

                }

                if (preg_match('/^(0x)?[0-9a-fA-F]{40}$/' , $this->Data['message']['text'])){
                    $WalletAddress = $this->Data['message']['text'];
                    $User = $this->SaveTelegramUser();
                    $User->update([
                        'WalletAddress' => $WalletAddress
                    ]);
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'حساب کاربری من' , 'callback_data' => 'حساب کاربری من' ]);

                    $text = "
آدرس ولت شما با موفقیت ثبت شد
هم اکنون میتوانید در مسابقات شرکت کنید و جوایز خود را دریافت کنید.
                ";
                    $this->ResponseWithPhoto($text , $inlineLayout, 'https://kryptoarena.fun/images/Robot/WalletAddress.png' );

                }

            }
        }

        return 'ok';


    }




    protected function SaveTelegramUser($ReferralID = null){

        if (TelegramUsers::where('TelegramUserID' , $this->GetUserInfo('id'))->count() > 0){
            $User = TelegramUsers::where('TelegramUserID' , $this->GetUserInfo('id'))->first();
        }else{
            $User = TelegramUsers::create([
                'TelegramUserID' => $this->ChatID,
                'TelegramChatID' => $this->ChatID,
                'ReferralID' => $ReferralID,
                'FirstName' => $this->GetUserInfo('first_name') ,
                'LastName' => $this->GetUserInfo('last_name') ,
                'UserName' => $this->GetUserInfo('username') ,
            ]);
        }

        return $User;
    }
    protected function GetUsernameOrName(TelegramUsers $users)
    {
        if ($users->UserName != null){
            return $users->UserName;
        }elseif($users->UserName == null && $users->FirstName != null ){
            return $users->FirstName . ' ' . $users->LastName;
        }elseif($users->UserName == null && $users->FirstName == null ){
            return $users->TelegramUserID;
        }
    }
    protected function GetUserInfo($RequestedInfo){
        if ($this->updates->isType('callback_query')){
            return $this->Data['callback_query']['from'][$RequestedInfo] ?? null;
        }else{
            return $this->Data['message']['from'][$RequestedInfo] ?? null;
        }
    }
    protected function SendChatAction($Action){
        $ChatAction = '';
        switch ($Action) {
            case 'UploadVideo':
                $ChatAction = Actions::UPLOAD_VIDEO;
                break;

            case 'SendText':
                $ChatAction = Actions::TYPING;
                break;

            case 'UPLOAD_PHOTO':
                $ChatAction = Actions::UPLOAD_PHOTO;
                break;

            case 'upload_document':
                $ChatAction = Actions::UPLOAD_DOCUMENT;
                break;
        }

        Telegram::sendChatAction([
            'chat_id' => $this->ChatID,
            'action' => $ChatAction
        ]);

    }
    protected function EditMessage($Message , $Keyboard = null , $PhotoAddress = null , $MediaType = 'photo' , $MediaData = null){


        if ($this->updates->isType('callback_query')){
            $MessageID =  $this->Data['callback_query']['message']['message_id'];
        }
        if ($PhotoAddress == null){
            $PhotoAddress = 'https://kryptoarena.fun/images/MainLogo.png';
        }
        if ($Keyboard){
            if ($MediaType == 'photo'){
                $this->SendChatAction('UPLOAD_PHOTO');
                Telegram::editMessageMedia([
                    'chat_id' => $this->ChatID,
                    'message_id' => $MessageID,
                    'media' => json_encode([
                        'type' => 'photo',
                        'media' => $PhotoAddress . '?version=1.0.6',
                        'caption' => $Message,
                        'parse_mode' => 'html',
                    ]),
                    'reply_markup' => json_encode([
                        'inline_keyboard' => $Keyboard,
                        'resize_keyboard' => true,
                        'one_time_keyboard' => true
                    ])
                ]);
            }
            elseif($MediaType == 'document'){
                $this->SendChatAction('upload_document');

                Telegram::editMessageMedia([
                    'chat_id' => $this->ChatID,
                    'message_id' => $MessageID,
                    'media' => json_encode([
                        'type' => 'document',
                        'media' => $PhotoAddress,
                        'caption' => $Message,
                        'parse_mode' => 'html',
                    ]),
                    'reply_markup' => json_encode([
                        'inline_keyboard' => $Keyboard,
                        'resize_keyboard' => true,
                        'one_time_keyboard' => true
                    ])
                ]);
            }
            elseif($MediaType == 'video'){
                $this->SendChatAction('UploadVideo');
//                $PhotoAddress = InputFile::create($PhotoAddress . '?version=1.0.2' );
                Telegram::editMessageMedia([
                    'chat_id' => $this->ChatID,
                    'message_id' => $MessageID,
                    'media' => json_encode([
                        'type' => 'video',
                        'media' => $PhotoAddress,
                        'caption' => $Message,
                        'parse_mode' => 'html',
                    ]),
                    'reply_markup' => json_encode([
                        'inline_keyboard' => $Keyboard,
                        'resize_keyboard' => true,
                        'one_time_keyboard' => true
                    ])
                ]);
            }
            else{
                $this->SendChatAction('SendText');
                Telegram::editMessageCaption([
                    'chat_id' => $this->ChatID,
                    'message_id' => $MessageID,
                    'caption' => $Message,
                    'parse_mode' => 'html'
                ]);
            }

        }else{
            $this->SendChatAction('SendText');
            Telegram::editMessageCaption([
                'chat_id' => $this->ChatID,
                'message_id' => $MessageID,
                'caption' => $Message,
                'parse_mode' => 'html'
            ]);
        }

    }
    protected function Response($Message , $Keyboard = null ){

        $this->SendChatAction('SendText');
        if ($Keyboard){
            Telegram::sendMessage([
                'chat_id' => $this->ChatID,
                'text' => $Message,
                'parse_mode' => 'html',
                'reply_markup' => json_encode([
                    'inline_keyboard' => $Keyboard,
                    'resize_keyboard' => true,
                    'one_time_keyboard' => true
                ])
            ]);
        }else{
            Telegram::sendMessage([
                'chat_id' => $this->ChatID,
                'text' => $Message,
                'parse_mode' => 'html',
            ]);
        }

    }
    protected function DeleteMessage(){
        if ($this->updates->isType('callback_query')){
            $MessageID =  $this->Data['callback_query']['message']['message_id'];
        }
        Telegram::deleteMessage([
            'chat_id' => $this->ChatID,
            'message_id' => $MessageID,
        ]);

    }
    protected function ResponseToID($UserID, $Message , $Keyboard = null ){

        $this->SendChatAction('SendText');
        if ($Keyboard){
            Telegram::sendMessage([
                'chat_id' => $UserID,
                'text' => $Message,
                'parse_mode' => 'html',
                'reply_markup' => json_encode([
                    'inline_keyboard' => $Keyboard,
                    'resize_keyboard' => true,
                    'one_time_keyboard' => true
                ])
            ]);
        }else{
            Telegram::sendMessage([
                'chat_id' => $this->ChatID,
                'text' => $Message,
                'parse_mode' => 'html',
            ]);
        }

    }
    protected function ResponseWithPhoto($Message , $Keyboard = null , $PhotoAddress = null , $ChatID = null){
        $this->SendChatAction('UPLOAD_PHOTO');
        if ($PhotoAddress == null){
            $PhotoAddress = InputFile::create(public_path('images/MainLogo.png'));
        }
        Telegram::sendPhoto([
            'chat_id' => $ChatID != null ? $ChatID :  $this->ChatID,
            'photo' => InputFile::create($PhotoAddress  . '?version=1.0.6'),
            'caption' => $Message,
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => $Keyboard,
                'resize_keyboard' => true,
                'one_time_keyboard' => true
            ])
        ]);

    }
    protected function ResponseWithDocument($Message , $Keyboard = null , $FileName = null , $Text = null){
        $this->SendChatAction('upload_document');
        $myfile = fopen($FileName, "w");
        fwrite($myfile, $Text);
        fclose($myfile);
        $PhotoAddress = InputFile::create($FileName);
        Telegram::sendDocument([
            'chat_id' => $this->ChatID,
            'document' => $PhotoAddress,
            'caption' => $Message,
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => $Keyboard,
                'resize_keyboard' => true,
                'one_time_keyboard' => true
            ])
        ]);
        File::delete($FileName);
    }
    protected function ResponseWithVideo($Message ,$FileAddress , $FileName = null, $FileDuration = null , $Keyboard = null){
        $this->SendChatAction('UploadVideo');


        if ($Keyboard){
            Telegram::sendVideo([
                'chat_id' => $this->ChatID,
                'video' => InputFile::create($FileAddress , $FileName . ' Tutorial Video' ),
                'duration' => $FileDuration,
                'caption' => $Message,
                'parse_mode' => 'html',
                'reply_markup' => json_encode([
                    'inline_keyboard' => $Keyboard,
                    'resize_keyboard' => true,
                    'one_time_keyboard' => true
                ])
            ]);
        }else{
            Telegram::sendVideo([
                'chat_id' => $this->ChatID,
                'video' => InputFile::create($FileAddress , $FileName . ' Tutorial Video' ),
                'duration' => $FileDuration,
                'caption' => $Message,
                'parse_mode' => 'html',
            ]);
        }



    }

    private function numToWords($number) {
        $N2W = new Number2Word();
        return $N2W->numberToWords($number);
    }
    private function numToWordForStages($number) {

        $N2W = new Number2Word();
        return $N2W->numToWordForStages($number);
    }
}
