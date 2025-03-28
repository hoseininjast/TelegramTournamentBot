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
                    'price_amount' => $request->Price,
                    'price_currency' => 'usd',
                    'order_id' => 'KryptoArena' .  rand(100000,10000000000),
                    'pay_currency' => 'MATICMAINNET',
                    'payout_currency' => 'MATICMAINNET',
                ];

            }elseif ($request->PaymentMethod == 'Ton'){
                $data = [
                    'price_amount' => $request->Price,
                    'price_currency' => 'usd',
                    'order_id' => 'KryptoArena' .  rand(100000,10000000000),
                    'pay_currency' => 'TON',
                    'payout_currency' => 'TON',
                ];
            }elseif ($request->PaymentMethod == 'USDTPOL'){
                $data = [
                    'price_amount' => $request->Price,
                    'price_currency' => 'usd',
                    'order_id' => 'KryptoArena' .  rand(100000,10000000000),
                    'pay_currency' => 'USDTMATIC',
                    'payout_currency' => 'USDTMATIC',
                ];
            }elseif ($request->PaymentMethod == 'USDTTON'){
                $data = [
                    'price_amount' => $request->Price,
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
                'price_amount' => $paymentDetails['price_amount'],
                'order_id' => $paymentDetails['order_id'],
            ];

            $Payment = Payments::create([
                'OrderID' => $paymentDetails['order_id'],
                'PaymentID' => $paymentDetails['payment_id'],
                'FiatAmount' => $paymentDetails['price_amount'],
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
            'PaymentID' => 'required|integer|exists:payments,PaymentID',
        ]);
        try {

            $NowPayment = new NowPayment(env('NOWPAYMENTS_API_KEY'));

            $payments = Payments::find($request->PaymentID);

            $paymentDetails = $NowPayment->getPaymentStatus($payments->PaymentID);

            $paymentDetails = json_decode($paymentDetails , true);

            if($payments->Status == 'Finished'){
                return [
                    'Message' => 'this payment paid successfully.',
                    'Code' => 5
                ];
            }

            if ($paymentDetails['payment_status'] == 'confirming' || $paymentDetails['payment_status'] == 'confirmed' || $paymentDetails['payment_status'] == 'sending'){
                return [
                    'Message' => 'confirming payment in blockchain , please wait for confirmation.',
                    'Code' => 1
                ];
            }
            if ($paymentDetails['payment_status'] == 'waiting' ){
                return [
                    'Message' => 'waiting for payment to be paid',
                    'Code' => 2
                ];
            }
            if ($paymentDetails['payment_status'] == 'failed' || $paymentDetails['payment_status'] == 'refunded' ||$paymentDetails['payment_status'] == 'expired'  ){

                $payments->update([
                    'Status' => 'Canceled'
                ]);

                return [
                    'Message' => 'the payment not completed due to the some errors',
                    'Code' => 3
                ];
            }
            if ($paymentDetails['payment_status'] == 'partially_paid'|| $paymentDetails['payment_status'] == 'finished'){


                $User = TelegramUsers::find($payments->UserID);
                $User->update([
                    'Charge' => $User->Charge + $payments->FiatAmount,
                ]);
                UserPaymentHistory::create([
                    'UserID' => $User->id,
                    'Description' => 'Wallet charged',
                    'Amount' => $payments->FiatAmount,
                    'Type' => 'In',
                ]);

                $payments->update([
                    'UserTransactionHash' => $paymentDetails['payin_hash'],
                    'Status' => 'Paid'
                ]);

                return [
                    'Message' => 'this payment has been finished successfully , the amount has been added to your wallet.',
                    'Code' => 4,
                ];



            }



        }catch (\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'failed'
            ],200);
        }
    }
}
