<?php

namespace App\Http\Controllers\Api\V1;

use App\Classes\NowPayment;
use App\Http\Controllers\Controller;
use App\Models\Payments;
use App\Models\TelegramUsers;
use App\Models\UserPaymentHistory;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function GetPrice($TokenName)
    {
        $cmc = new \CoinMarketCap\Api(env('CMC_API_KEY'));
        $response = $cmc->cryptocurrency()->quotesLatest(['symbol' => $TokenName]);
        return response()->json([
            'Price' => $response->data
        ], 200); ;

    }


    public function Create(Request $request  )
    {
        $request->validate([
            'PaymentMethod' => 'required|string|in:Polygon,TON,USDTPOL,USDTTON',
            'Price' => 'required|numeric|min:1',
            'UserID' => 'required|integer|exists:telegram_users,id',
        ]);

        try {
            if ($request->PaymentMethod == 'Polygon'){

                $data = [
                    'price_amount' => $request->Price + 0.2,
                    'price_currency' => 'usd',
                    'order_id' => 'KryptoArena' .  rand(100000,10000000000),
                    'pay_currency' => 'MATICMAINNET',
                    'payout_currency' => 'MATICMAINNET',
                ];

            }elseif ($request->PaymentMethod == 'Ton'){
                $data = [
                    'price_amount' => $request->Price + 0.2,
                    'price_currency' => 'usd',
                    'order_id' => 'KryptoArena' .  rand(100000,10000000000),
                    'pay_currency' => 'TON',
                    'payout_currency' => 'TON',
                ];
            }elseif ($request->PaymentMethod == 'USDTPOL'){
                $data = [
                    'price_amount' => $request->Price + 0.2,
                    'price_currency' => 'usd',
                    'order_id' => 'KryptoArena' .  rand(100000,10000000000),
                    'pay_currency' => 'USDTMATIC',
                    'payout_currency' => 'USDTMATIC',
                ];
            }elseif ($request->PaymentMethod == 'USDTTON'){
                $data = [
                    'price_amount' => $request->Price + 0.2,
                    'price_currency' => 'usd',
                    'order_id' => 'KryptoArena' .  rand(100000,10000000000),
                    'pay_currency' => 'USDTTON',
                    'payout_currency' => 'USDTTON',
                ];
            }



            $NowPayment = new NowPayment(env('NOWPAYMENTS_API_KEY'));


            $paymentDetails = $NowPayment->createPayment($data);
            $paymentDetails = json_decode($paymentDetails , true);

            $PD = [
                'payment_id' => $paymentDetails['payment_id'],
                'pay_address' => $paymentDetails['pay_address'],
                'pay_amount' => $paymentDetails['pay_amount'],
                'price_amount' => $request->Price,
                'order_id' => $paymentDetails['order_id'],
            ];

            $Payment = Payments::create([
                'OrderID' => $paymentDetails['order_id'],
                'PaymentID' => $paymentDetails['payment_id'],
                'FiatAmount' => $request->Price,
                'CryptoAmount' => $paymentDetails['pay_amount'],
                'PaymentMethod' => $request->PaymentMethod,
                'PayingAddress' => $paymentDetails['pay_address'],
                'Status' => 'Pending',
                'UserID' => $request->UserID,
            ]);



            return response()->json([
                'Data' => $PD,
                'PaymentID' => $Payment->id,
                'Code' => 200,
                'Status' => true,
                'Message' => 'Invoice Created successfully'
            ] , 200);
        }catch (\Exception $exception){
            return response()->json([
                'message' => $exception->getMessage(),
                'status' => 'failed'
            ],200);
        }




    }

    public function Check(Request $request)
    {
        $request->validate([
            'PaymentID' => 'required|integer|exists:payments,id',
        ]);
        try {

            $NowPayment = new NowPayment(env('NOWPAYMENTS_API_KEY'));

            $payments = Payments::find($request->PaymentID);

            $paymentDetails = $NowPayment->getPaymentStatus($payments->PaymentID);

            $paymentDetails = json_decode($paymentDetails , true);

            if($payments->Status == 'Finished'){
                return response()->json([
                    'Code' => 5,
                    'Message' => 'this payment paid successfully.'
                ] , 200);


            }

            if ($paymentDetails['payment_status'] == 'confirming' || $paymentDetails['payment_status'] == 'confirmed' || $paymentDetails['payment_status'] == 'sending'){

                return response()->json([
                    'Code' => 1,
                    'Message' => 'confirming payment in blockchain , please wait for confirmation.'
                ] , 200);
            }
            if ($paymentDetails['payment_status'] == 'waiting' ){

                return response()->json([
                    'Code' => 2,
                    'Message' => 'waiting for payment to be paid'
                ] , 200);
            }
            if ($paymentDetails['payment_status'] == 'failed' || $paymentDetails['payment_status'] == 'refunded' ||$paymentDetails['payment_status'] == 'expired'  ){

                $payments->update([
                    'Status' => 'Canceled'
                ]);


                return response()->json([
                    'Code' => 3,
                    'Message' => 'the payment not completed due to the some errors'
                ] , 200);


            }
            if ($paymentDetails['payment_status'] == 'partially_paid'|| $paymentDetails['payment_status'] == 'finished'){


                $User = TelegramUsers::find($payments->UserID);
                $User->update([
                    'Charge' => $User->Charge + $payments->FiatAmount,
                ]);
                UserPaymentHistory::create([
                    'UserID' => $User->id,
                    'Description' => 'Deposit : Wallet charged',
                    'Amount' => $payments->FiatAmount,
                    'Type' => 'In',
                ]);

                $payments->update([
                    'UserTransactionHash' => $paymentDetails['payin_hash'],
                    'Status' => 'Paid'
                ]);



                $DepositCount = Payments::where('UserID' , $User->id)->where('Status' , 'Paid')->count();

                if($DepositCount == 1){
                    $Deposit = Payments::where('UserID' , $User->id)->where('Status' , 'Paid')->first();
                    if($Deposit->FiatAmount > 3){
                        $Bonus = 20;
                        $BonusAmount = ($payments->FiatAmount / 100) * $Bonus;
                        $User->update([
                            'Charge' => $User->Charge + $BonusAmount,
                        ]);
                    }

                }elseif($DepositCount == 2){
                    $Deposit = Payments::where('UserID' , $User->id)->where('Status' , 'Paid')->skip(1)->first();
                    if($Deposit->FiatAmount > 6){
                        $Bonus = 30;
                        $BonusAmount = ($payments->FiatAmount / 100) * $Bonus;
                        $User->update([
                            'Charge' => $User->Charge + $BonusAmount,
                        ]);
                    }


                }elseif($DepositCount == 3){
                    $Deposit = Payments::where('UserID' , $User->id)->where('Status' , 'Paid')->skip(2)->first();
                    if($Deposit->FiatAmount > 9){
                        $Bonus = 40;
                        $BonusAmount = ($payments->FiatAmount / 100) * $Bonus;
                        $User->update([
                            'Charge' => $User->Charge + $BonusAmount,
                        ]);
                    }

                }




                return response()->json([
                    'Code' => 4,
                    'Message' => 'this payment has been finished successfully , the amount has been added to your wallet.'
                ] , 200);



            }



        }catch (\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'failed'
            ],200);
        }
    }


    public function Transfer(Request $request)
    {
        $request->validate([
            'UserID' => 'required|integer|exists:telegram_users,id',
            'Amount' => 'required|numeric|min:2000',
            'ReceiverUserID' => 'required|integer|exists:telegram_users,id',
        ]);



        $User = TelegramUsers::find($request->UserID);
        $ReceiverUser = TelegramUsers::find($request->ReceiverUserID);

        $Amount = $request->Amount;
        $Fee = ($Amount / 100) * 10;
        $Total = $Amount + $Fee;
        $AmountToRemove = $Total / 1000;
        $AmountToAdd = $Amount / 1000;


        if($User->Charge > $AmountToRemove){



            $User->update([
                'Charge' => $User->Charge - $AmountToRemove,
            ]);

            UserPaymentHistory::create([
                'UserID' => $User->id,
                'Description' => "Transfer KAC To : {$ReceiverUser->UserName}",
                'Amount' => $AmountToRemove,
                'Type' => 'Transfer',
            ]);



            $ReceiverUser->update([
                'Charge' => $ReceiverUser->Charge + $AmountToAdd,
            ]);

            UserPaymentHistory::create([
                'UserID' => $ReceiverUser->id,
                'Description' => "Receive KAC From : {$User->UserName}",
                'Amount' => $AmountToAdd,
                'Type' => 'In',
            ]);


            return response()->json([
                'Data' => [
                    'Message' => 'Transfer completed successfully.',
                    'Code' => 1,
                    'Status' => true,
                ],
            ] , 200);

        }else{

            return response()->json([
                'Data' => [
                    'Message' => 'You do not have enough KAC to transfer.',
                    'Code' => 2,
                    'Status' => false,
                ],
            ] , 200);




        }




    }



    public function Swap(Request $request)
    {
        $request->validate([
            'UserID' => 'required|integer|exists:telegram_users,id',
            'Amount' => 'required|numeric|min:1',
        ]);



        $User = TelegramUsers::find($request->UserID);

        $Amount = $request->Amount;

        $FeePercent = null;
        if($Amount <= 10){
            $FeePercent = 6;
        }else if($Amount > 10 && $Amount <= 50){
            $FeePercent = 3;
        }else if($Amount > 50 ){
            $FeePercent = 1;
        }


        $Fee = ($Amount / 100) * $FeePercent;
        $Total = $Amount ;
        $AmountToRemove = $Total;
        $AmountToAdd = ($Amount * 1000) - ($Fee * 1000);


        if($User->KAT >= $AmountToRemove){



            $User->update([
                'Charge' => $User->Charge + $Amount,
                'KAT' => $User->KAT - $AmountToRemove,
            ]);

            UserPaymentHistory::create([
                'UserID' => $User->id,
                'Description' => "Swap {$AmountToRemove} KAT To {$AmountToAdd} KAC",
                'Amount' => $AmountToRemove,
                'Type' => 'Swap',
                'Currency' => 'KAT',
            ]);





            return response()->json([
                'Data' => [
                    'Message' => 'Swap completed successfully.',
                    'Code' => 1,
                    'Status' => true,
                ],
            ] , 200);

        }else{

            return response()->json([
                'Data' => [
                    'Message' => 'You do not have enough KAT to Swap.',
                    'Code' => 2,
                    'Status' => false,
                ],
            ] , 200);




        }




    }


}
