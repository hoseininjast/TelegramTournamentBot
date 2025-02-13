<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\Uploader;
use App\Models\Games;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class GamesController extends Controller
{
    public function index()
    {
        $Games = Games::all();
        return response()->json([
            'Data' => $Games,
        ] , 200);
    }
}
