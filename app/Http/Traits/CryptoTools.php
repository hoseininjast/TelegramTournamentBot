<?php


namespace App\Http\Traits;



use App\Classes\CoinMarketCap;
use App\Classes\NowPayment;
use App\Models\Payments;
use App\Models\TelegramUsers;
use App\Models\UserPaymentHistory;

trait CryptoTools
{
    protected function GetMaticPrice()
    {
        $cmc = new CoinMarketCap(env('CMC_API_KEY'));
        $response = $cmc->cryptocurrency()->quotesLatest(['symbol' => 'MATIC']);
        return $response->data->MATIC->quote->USD->price;
    }

    protected function GetTONPrice()
    {
        $cmc = new CoinMarketCap\Api(env('CMC_API_KEY'));
        $response = $cmc->cryptocurrency()->quotesLatest(['symbol' => 'TON']);
        return $response->data->TON->quote->USD->price;
    }
    protected function GetNOTPrice()
    {
        $cmc = new CoinMarketCap\Api(env('CMC_API_KEY'));
        $response = $cmc->cryptocurrency()->quotesLatest(['symbol' => 'NOT']);
        return $response->data->NOT->quote->USD->price ;
    }

    protected function GetDOGSPrice()
    {
        $cmc = new CoinMarketCap\Api(env('CMC_API_KEY'));
        $response = $cmc->cryptocurrency()->quotesLatest(['symbol' => 'DOGS']);
        return $response->data->DOGS->quote->USD->price ;
    }


    protected function GetCryptoPrice($TokenName)
    {
        $cmc = new CoinMarketCap\Api(env('CMC_API_KEY'));
        $response = $cmc->cryptocurrency()->quotesLatest(['symbol' => $TokenName]);
        return $response->data->$TokenName->quote->USD->price ;
    }


    public function CreatePaymentOrder($PaymentMethod , $Price  )
    {


        if ($PaymentMethod == 'Polygon'){

            $data = [
                'price_amount' => $Price,
                'price_currency' => 'usd',
                'order_id' => 'KryptoArena' .  rand(100000,10000000000),
                'pay_currency' => 'MATICMAINNET',
                'payout_currency' => 'MATICMAINNET',
            ];

        }elseif ($PaymentMethod == 'Ton'){
            $data = [
                'price_amount' => $Price,
                'price_currency' => 'usd',
                'order_id' => 'KryptoArena' .  rand(100000,10000000000),
                'pay_currency' => 'TON',
                'payout_currency' => 'TON',
            ];
        }elseif ($PaymentMethod == 'USDTPOS'){
            $data = [
                'price_amount' => $Price,
                'price_currency' => 'usd',
                'order_id' => 'KryptoArena' .  rand(100000,10000000000),
                'pay_currency' => 'USDTMATIC',
                'payout_currency' => 'USDTMATIC',
            ];
        }elseif ($PaymentMethod == 'USDTTON'){
            $data = [
                'price_amount' => $Price,
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


        return $PD;


    }

    public function CheckPaymentStatus(Payments $payments)
    {
        try {

            $NowPayment = new NowPayment(env('NOWPAYMENTS_API_KEY'));


            $paymentDetails = $NowPayment->getPaymentStatus($payments->PaymentID);

            $paymentDetails = json_decode($paymentDetails , true);

            if($payments->Status == 'Finished'){
                return [
                    'Message' => 'ایک فاکتور قبلا پرداخت شده است.',
                    'Code' => 5
                ];
            }

            if ($paymentDetails['payment_status'] == 'confirming' || $paymentDetails['payment_status'] == 'confirmed' || $paymentDetails['payment_status'] == 'sending'){
                return [
                    'Message' => 'درحال پردازش فاکتور در بلاکچین.',
                    'Code' => 1
                ];
            }
            if ($paymentDetails['payment_status'] == 'waiting' ){
                return [
                    'Message' => 'در انتظار پرداخت فاکتور.',
                    'Code' => 2
                ];
            }
            if ($paymentDetails['payment_status'] == 'failed' || $paymentDetails['payment_status'] == 'refunded' ||$paymentDetails['payment_status'] == 'expired'  ){

                $payments->update([
                    'Status' => 'Canceled'
                ]);

                return [
                    'Message' => 'به دلیل مشکلاتی پرداخت انجام نشد.',
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
                    'Message' => 'پرداخت شما با موفقیت انجام شد. مبلغ پرداختی به کیف پول شما اضافه شده است .',
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
