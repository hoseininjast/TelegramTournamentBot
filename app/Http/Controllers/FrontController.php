<?php

namespace App\Http\Controllers;

use App\Models\Games;
use App\Models\ReferralPlan;
use App\Models\ReferralPlanHistory;
use App\Models\TelegramUsers;
use App\Models\TimeTable;
use App\Models\UserPaymentHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class FrontController extends Controller
{
    public function index()
    {
        return redirect()->route('Front.Profile.index');
    }
    public function Test()
    {
        return redirect()->route('Front.Profile.index');
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
        $FileAddress = preg_replace('/https:\/\/kryptoarena\.fun\//' , '' , $TimeTable->Image);

        return Response::download($TimeTable->Image, 'TimeTable-'.$thisMonth.'.png', $headers);
        return response()->download($TimeTable->Image);
    }
}
