<?php

namespace App\Http\Controllers;

use App\Classes\NowPayment;

class WebController extends Controller
{
    public function index()
    {
        $data = [
            'price_amount' => 1,
            'price_currency' => 'usd',
            'order_id' => '1' .  rand(100000,10000000000),
            'pay_currency' => 'MATICMAINNET',
            'payout_currency' => 'MATICMAINNET',
        ];

        $NowPayment = new NowPayment(env('NOWPAYMENTS_API_KEY'));


        $paymentDetails = $NowPayment->createPayment($data);

        $paymentDetails = json_decode($paymentDetails , true);
        dd($paymentDetails);

        return view('Dashboard.index');
    }
    public function GotoDashboard()
    {
        return redirect()->route('Dashboard.index');
    }
}
