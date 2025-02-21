<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\Uploader;
use App\Models\Games;
use App\Models\TelegramUsers;
use App\Models\Tournaments;
use App\Models\UserPaymentHistory;
use App\Models\UserTournaments;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Telegram\Bot\Api;
use Telegram\Bot\Laravel\Facades\Telegram;

class TournamentsController extends Controller
{
    public function index()
    {
        $Tournaments = Tournaments::all();
        return response()->json([
            'Data' => [
                'Tournaments' => $Tournaments
            ],
        ] , 200);
    }

    public function Detail(int $ID)
    {
        $Tournaments = Tournaments::find($ID);
        return response()->json([
            'Data' => [
                'Tournament' => $Tournaments
            ],
        ] , 200);
    }

    public function Join(Request $request)
    {
        $request->validate([
            'TournamentID' => 'required|int|exists:tournaments,id',
            'UserID' => 'required|int|exists:telegram_users,TelegramUserID',
        ]);

        $Tournaments = Tournaments::find($request->TournamentID);
        $User = TelegramUsers::where('TelegramUserID' , $request->UserID)->first();

        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

        $ChanelID = $telegram->getChat(['chat_id' => '@krypto_arena']);
        $JoinInfo = $telegram->getChatMember([
            'chat_id' => $ChanelID['id'],
            'user_id' => $User->TelegramUserID,
        ]);
        if($JoinInfo['status'] == 'creator' || $JoinInfo['status'] == 'administrator'|| $JoinInfo['status'] == 'member'){
            if ($Tournaments->Players()->count() < $Tournaments->PlayerCount){
                if(!$Tournaments->isJoined($User->id)){
                    if($User->PlatoID){
                        if($Tournaments->Mode == 'Free'){
                            UserTournaments::create([
                                'UserID' => $User->id,
                                'TournamentID' => $Tournaments->id,
                            ]);
                            $text = "You have successfully entered the tournament. After the draw and the order of the games are determined, you will be informed of the game schedule.";
                            $Code = 200;
                        }elseif($Tournaments->Mode == 'Paid'){

                            if ($User->Charge >= $Tournaments->Price){
                                $User->update([
                                    'Charge' => $User->Charge - $Tournaments->Price
                                ]);
                                UserPaymentHistory::create([
                                    'UserID' => $User->id,
                                    'Description' => 'Tournament joined',
                                    'Amount' => $Tournaments->Price,
                                    'Type' => 'Out',
                                ]);
                                UserTournaments::create([
                                    'UserID' => $User->id,
                                    'TournamentID' => $Tournaments->id,
                                ]);
                                $text = "You have successfully entered the tournament. After the draw and the order of the games are determined, you will be informed of the game schedule.";
                                $Code = 200;
                            }else{
                                $text = "Your wallet does not have enough funds to join the tournament, please top up your wallet and then join.";
                                $Code = 300;
                            }
                        }
                    }else{
                        $text = "You have not yet verified your Plato ID. After verification, try to join again.";
                        $Code = 301;
                    }

                }
                else{
                    $text = "You have participated in this tournament before.";
                    $Code = 201;

                }
            }else{
                $text = "Unfortunately, the number of players in this tournament is limited and you cannot participate in it. Please select another tournament from the tournaments menu.";
                $Code = 302;
            }

        }else{
            return response()->json([
                'Message' => 'You Must join our chanel first',
                'Code' => 400
            ] , 200);
        }



        return response()->json([
            'Message' => 'You Must join our chanel first',
            'Code' => $Code
        ] , 200);

    }

    public function JoinStatus(Request $request)
    {
        $request->validate([
            'TournamentID' => 'required|int|exists:tournaments,id',
            'UserID' => 'required|int|exists:telegram_users,TelegramUserID',
        ]);

        $Tournaments = Tournaments::find($request->TournamentID);
        $User = TelegramUsers::where('TelegramUserID' , $request->UserID)->first();

        if($Tournaments->isJoined($User->id)){
            return response()->json([
                'Message' => 'User already joined',
                'Code' => 1
            ] , 200);
        }else{
            return response()->json([
                'Message' => 'you can join this tournament',
                'Code' => 2
            ] , 200);
        }

    }

}
