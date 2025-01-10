<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Controller;
use App\Models\Games;
use App\Models\TelegramUsers;
use App\Models\Tournaments;
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
                Keyboard::inlineButton(['text' => '💎تاریخچه💎', 'callback_data' => 'تورنومنت ها']),
                Keyboard::inlineButton(['text' => '💎تورنومنت ها💎', 'callback_data' => 'تورنومنت ها']),
            ],
            [
                Keyboard::inlineButton(['text' => 'حساب کاربری من', 'callback_data' => 'حساب کاربری من']),
            ],
            [
                Keyboard::inlineButton(['text' => 'کانال ما', 'callback_data' => 'پشتیبانی وی پی ان']),
                Keyboard::inlineButton(['text' => 'گروه ما', 'callback_data' => 'درباره ما']),
                Keyboard::inlineButton(['text' => 'گروه پلاتو', 'callback_data' => 'دریافت سرویس تست']),
            ],
            [
                Keyboard::inlineButton(['text' => '🆘پشتیبانی🆘', 'callback_data' => 'پشتیبانی']),
                Keyboard::inlineButton(['text' => '🔐 درباره ما 🔐', 'callback_data' => 'درباره ما']),
            ],
        ];

        if ($updates->isType('callback_query') ){


            if ($this->Data['callback_query']['data'] == 'صفحه اصلی'){
                $this->EditMessage("💎سلام به ربات Krypto Arena خوش آمدید💎 \nلطفا از گزینه های زیر یکی رو انتخاب کنید" , $MainMenuKeyboard );
            }

            if ($this->Data['callback_query']['data'] == 'حساب کاربری من'){
                $User = $this->SaveTelegramUser();

                if($User->PlatoID){
                    $inlineLayout = [
                        [
                            Keyboard::inlineButton(['text' => 'شارژ کیف پول', 'callback_data' => 'null']),
                        ],

                    ];
                }else{
                    $inlineLayout = [
                        [
                            Keyboard::inlineButton(['text' => 'احراز هویت پلاتو', 'callback_data' => 'احراز هویت پلاتو']),
                        ],
                        [
                            Keyboard::inlineButton(['text' => 'شارژ کیف پول', 'callback_data' => 'null']),
                        ],

                    ];
                }

                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'صفحه اصلی' ]);
                $PlatoID = $User->PlatoID ? $User->PlatoID : 'ثبت نشده';
                $text = "
در این صفحه شما میتوانید اکانت خود را مدیریت کنید
شارژ کیف پول : $0
تعداد بازی ها : 0
تعداد برد ها : 0
آیدی پلاتو : {$PlatoID}
";
                $this->EditMessage($text , $inlineLayout );
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

                $this->EditMessage($text , $inlineLayout );
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

                $this->EditMessage($text , $inlineLayout );
            }

            if ($this->Data['callback_query']['data'] == 'Free'){

                $inlineLayout = [];
                foreach (Games::all() as $game) {
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => $game->Name , 'callback_data' => 'FreeTournamentList-' . $game->id ]);
                }
                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'تورنومنت ها' ]);

                $text = 'لطفا بازی را انتخاب کنید.';

                $this->EditMessage($text , $inlineLayout );
            }

            if ($this->Data['callback_query']['data'] == 'Paid'){

                $inlineLayout = [];
                foreach (Games::all() as $game) {
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => $game->Name , 'callback_data' => 'PaidTournamentList-' . $game->id ]);
                }
                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'تورنومنت ها' ]);

                $text = 'لطفا بازی را انتخاب کنید.';

                $this->EditMessage($text , $inlineLayout );
            }


            if (preg_match('/^FreeTournamentList-/' , $this->Data['callback_query']['data'])){
                $GameID = preg_replace("/^FreeTournamentList-/", "", $this->Data['callback_query']['data']);

                $inlineLayout = [];
                $Tournaments = Tournaments::where('GameID' , $GameID)->where('Mode' , 'Free')->get();
                foreach ($Tournaments as $tournament) {
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => $tournament->Name , 'callback_data' => 'Tournament-' . $tournament->id ]);
                }
                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'Free' ]);

                $text = "
لطفا تورنومنت مد نظر خود را انتخاب کنید.
                ";
                $this->EditMessage($text , $inlineLayout );

            }

            if (preg_match('/^PaidTournamentList-/' , $this->Data['callback_query']['data'])){
                $GameID = preg_replace("/^PaidTournamentList-/", "", $this->Data['callback_query']['data']);

                $inlineLayout = [];
                $Tournaments = Tournaments::where('GameID' , $GameID)->where('Mode' , 'Paid')->get();
                foreach ($Tournaments as $tournament) {
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => $tournament->Name , 'callback_data' => 'Tournament-' . $tournament->id ]);
                }
                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'Paid' ]);

                $text = "
لطفا تورنومنت مد نظر خود را انتخاب کنید.
                ";
                $this->EditMessage($text , $inlineLayout );

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

                $RemainingCount = $Tournaments->PlayerCount - $Tournaments->Players()->count();
                $text = "
نام : {$Tournaments->Name}
توضیحات : {$Tournaments->Description}
نوع : {$Type}
حالت : {$Mode}
 مبلغ ورودی : $ {$Tournaments->Price}
تعداد بازیکن : {$Tournaments->PlayerCount}
جایگاه های باقی مانده : {$RemainingCount} عدد
زمان بازی : {$Tournaments->Time} روز
تاریخ شروع : {$Tournaments->Start}
تعداد برندگان : {$Tournaments->Winners}
جوایز : \n {$adwards}
وضعیت : {$Status}
                ";
                if($this->User->PlatoID){
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'ثبت نام در تورنومنت' , 'callback_data' => 'JoinTournament-'.$Tournaments->id ]);
                }else{
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'احراز هویت پلاتو', 'callback_data' => 'احراز هویت پلاتو']);
                }
                if($Tournaments->Mode == 'Free'){
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'FreeTournamentList-' . $Tournaments->Game->id ]);
                }else{
                    $inlineLayout[][] = Keyboard::inlineButton(['text' => 'مرحله قبل' , 'callback_data' => 'PaidTournamentList-' . $Tournaments->Game->id ]);
                }

                $this->EditMessage($text , $inlineLayout );

            }


            if (preg_match('/^JoinTournament-/' , $this->Data['callback_query']['data'])){
                $TournamentID = preg_replace("/^JoinTournament-/", "", $this->Data['callback_query']['data']);

                $inlineLayout = [];
                $Tournaments = Tournaments::find($TournamentID);

                if($this->User->PlatoID){
                    $UserCount = $Tournaments->Players()->count();
                    if($UserCount < $Tournaments->PlayerCount){
                        UserTournaments::create([
                            'UserID' => $this->User->id,
                            'TournamentID' => $Tournaments->id,
                        ]);
                        $text = "شما با موفقیت وارد تورنومنت شدید. پس از قرعه کشی و مشخص شدن ترتیب بازی ها ، برنامه بازی ها به شما اطلاعات داده خواهد شد.";
                    }else{
                        $text = "متاسفانه تعداد بازی کنان این مسابفه تکیل شده است و شما نمیتوانید در آن شرکت کنید ، لطفا از منوی تورنومنت ها ،‌مسابقه دیگری را انتخاب کنید.";
                    }
                }else{
                    $text = "شما هنوز آیدی پلاتو خود را احراز نکرده اید ،‌پس از احراز هویت مجددا برای عضویت تلاش کنید.";
                }

                $inlineLayout[][] = Keyboard::inlineButton(['text' => 'صفحه اصلی' , 'callback_data' => 'صفحه اصلی'  ]);


                $this->EditMessage($text , $inlineLayout );

            }





        }
        elseif ($updates->isType('message') ){
            if (isset($this->Data['message']['text'])){

                if ($this->Data['message']['text'] == '/start' || $this->Data['message']['text'] == 'start'){
                    $this->ResponseWithPhoto("🌠💸🤝سلام به ربات Krypto Arena خوش آمدید\nلطفا از گزینه های زیر یکی رو انتخاب کنید🤝💸🌠" , $MainMenuKeyboard , 'https://platotournament.ai1polaris.com/images/MainLogo.png' );
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

                    $this->ResponseWithPhoto($text , $inlineLayout  , 'https://platotournament.ai1polaris.com/images/MainLogo.png');
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
                    $this->ResponseWithPhoto($text , $inlineLayout, 'https://platotournament.ai1polaris.com/images/MainLogo.png' );

                }


            }
        }

        return 'ok';


    }




    protected function SaveTelegramUser(){

        if (TelegramUsers::where('TelegramUserID' , $this->GetUserInfo('id'))->count() > 0){
            $User = TelegramUsers::where('TelegramUserID' , $this->GetUserInfo('id'))->first();
        }else{
            $User = TelegramUsers::create([
                'TelegramUserID' => $this->GetUserInfo('id'),
                'TelegramChatID' => $this->ChatID,
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
            $PhotoAddress = 'https://platotournament.ai1polaris.com/images/MainLogo.png';
        }
        if ($Keyboard){
            if ($MediaType == 'photo'){
                $this->SendChatAction('UPLOAD_PHOTO');
                Telegram::editMessageMedia([
                    'chat_id' => $this->ChatID,
                    'message_id' => $MessageID,
                    'media' => json_encode([
                        'type' => 'photo',
                        'media' => $PhotoAddress . '?version=1.0.4',
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
    protected function ResponseWithPhoto($Message , $Keyboard = null , $PhotoAddress = null ){
        $this->SendChatAction('UPLOAD_PHOTO');
        if ($PhotoAddress == null){
            $PhotoAddress = InputFile::create(public_path('images/MainLogo.png'));
        }
        Telegram::sendPhoto([
            'chat_id' => $this->ChatID,
            'photo' => InputFile::create($PhotoAddress  . '?version=1.0.4'),
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

}
