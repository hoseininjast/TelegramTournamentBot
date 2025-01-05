<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Controller;
use App\Models\TelegramUsers;
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

//        $this->User = $this->SaveTelegramUser();

        Log::info('kos');

        $MainMenuKeyboard = [
            [
                Keyboard::inlineButton(['text' => '💎تورنومنت ها💎', 'callback_data' => 'مدیریت سرویس']),
            ],
            [
                Keyboard::inlineButton(['text' => 'کانال ما', 'callback_data' => 'پشتیبانی وی پی ان']),
                Keyboard::inlineButton(['text' => 'گروه ما', 'callback_data' => 'درباره ما']),
            ],
            [
                Keyboard::inlineButton(['text' => 'گروه پلاتو', 'callback_data' => 'دریافت سرویس تست']),
                Keyboard::inlineButton(['text' => 'حساب کاربری من', 'callback_data' => 'دریافت سرویس تست']),
            ],

            [
                Keyboard::inlineButton(['text' => '🆘پشتیبانی🆘', 'callback_data' => 'پشتیبانی وی پی ان']),
                Keyboard::inlineButton(['text' => '🔐 درباره ما 🔐', 'callback_data' => 'درباره ما']),
            ],
        ];

        if ($updates->isType('callback_query') ){
            if ($this->Data['callback_query']['data'] == 'صفحه اصلی'){

                $this->EditMessage("🌠💸🤝سلام به ربات Polaris خوش آمدید\nلطفا از گزینه های زیر یکی رو انتخاب کنید🤝💸🌠" , $MainMenuKeyboard );

            }
        }
        elseif ($updates->isType('message') ){
            if (isset($this->Data['message']['text'])){
                if ($this->Data['message']['text'] == '/start' || $this->Data['message']['text'] == 'start'){
                    $this->ResponseWithPhoto("🌠💸🤝سلام به ربات Polaris خوش آمدید\nلطفا از گزینه های زیر یکی رو انتخاب کنید🤝💸🌠" , $MainMenuKeyboard);
                }
            }
        }

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
            $PhotoAddress = 'https://vpn.ai1polaris.com/images/New/0.png';
        }
        if ($Keyboard){
            if ($MediaType == 'photo'){
                $this->SendChatAction('UPLOAD_PHOTO');
                Telegram::editMessageMedia([
                    'chat_id' => $this->ChatID,
                    'message_id' => $MessageID,
                    'media' => json_encode([
                        'type' => 'photo',
                        'media' => $PhotoAddress . '?version=1.0.3',
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
            $PhotoAddress = 'https://vpn.ai1polaris.com/images/0.png';
        }
        Telegram::sendPhoto([
            'chat_id' => $this->ChatID,
            'photo' => $PhotoAddress,
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
