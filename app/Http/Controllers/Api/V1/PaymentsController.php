<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
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
}
