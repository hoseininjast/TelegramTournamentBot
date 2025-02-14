<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\Uploader;
use App\Models\Games;
use App\Models\Tournaments;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

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


}
