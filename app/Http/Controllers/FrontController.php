<?php

namespace App\Http\Controllers;

use App\Models\Games;
use App\Models\TimeTable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class FrontController extends Controller
{
    public function index()
    {
        return redirect()->route('Front.Tournaments.Champions');
    }
    public function Games()
    {
        $Games = Games::all();
        return view('Front.Games.index')->with('Games', $Games);
    }
    public function TimeTable()
    {
        $TimeTable = TimeTable::first();
        return view('Front.TimeTable.index')->with('TimeTable', $TimeTable);
    }
    public function DownloadTimeTable()
    {
        $TimeTable = TimeTable::first();
        $thisMonth = Carbon::now()->month;
        $headers = array(
            'Content-Type: application/image',
        );
        return Response::download($TimeTable->Image, 'TimeTable-'.$thisMonth.'.png', $headers);
        return response()->download($TimeTable->Image);
    }
}
