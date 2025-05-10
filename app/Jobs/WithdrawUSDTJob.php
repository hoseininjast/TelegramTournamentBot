<?php

namespace App\Jobs;

use App\Models\TelegramUsers;
use App\Models\UserPaymentHistory;
use App\Models\Withdraws;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mockery\Exception;
use Telegram\Bot\Api;
use Telegram\Bot\Laravel\Facades\Telegram;

class WithdrawUSDTJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $failOnTimeout = false;
    public $timeout = 120000;
    /**
     * Create a new job instance.
     */
    private $WithdrawID  = null;
    public function __construct(int $WithdrawID)
    {
        $this->$WithdrawID = $WithdrawID;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $Withdraw = Withdraws::find($this->WithdrawID);
        $User = TelegramUsers::find($Withdraw->UserID);

        $Address = $Withdraw->PayingAddress;
        $Amount = $Withdraw->Amount;

        try {




            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', 'https://transfertokenapi.chbk.app/TransferUSDT' , [
                'json' => [
                    'amount' => $Amount ,
                    'receiver' => $Address ,
                ]
            ]);
            $TransactionData = json_decode($response->getBody(), true);
            if ($TransactionData['status'] == true || $TransactionData['txhash'] != null){

                $Withdraw->update([
                    'UserTransactionHash' => $TransactionData['txhash'],
                    'Status' => 'Paid'
                ]);

                UserPaymentHistory::create([
                    'UserID' => $User->id,
                    'Description' => 'Withdraw KAT ',
                    'Amount' => $Amount,
                    'Currency' => 'KAT',
                    'Type' => 'Out',
                    'TransactionHash' => $TransactionData['txhash'],
                ]);

                $text = "Your Withdraw has been finished successfully.";
                NotifyTelegramUsersJob::dispatch($User->TelegramUserID , $text);
            }

        }catch (Exception $exception){
            $Withdraw->update([
                'Status' => 'Canceled'
            ]);
            $User->update([
                'KAT' => $User->KAT + $Amount,
            ]);
            $text = "Your Withdraw has been canceled , please try again for withdrawing money.";
            NotifyTelegramUsersJob::dispatch($User->TelegramUserID , $text);
        }



    }
}
