<?php

namespace App\Http\Controllers;

use App\Classes\NowPayment;
use App\Models\TelegramUsers;
use Telegram\Bot\Api;

class WebController extends Controller
{
    public function index()
    {
        return view('Dashboard.index');
    }
    public function GotoDashboard()
    {
        $Supervisor = \Auth::user();

        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $SupervisorTelegramInfo = $telegram->getChat(['chat_id' => $Supervisor->TelegramUserID]);
        dd($SupervisorTelegramInfo['username']);
        return redirect()->route('Dashboard.index');
    }
}
