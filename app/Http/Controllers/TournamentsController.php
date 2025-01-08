<?php

namespace App\Http\Controllers;

use App\Models\Games;
use App\Models\Tournaments;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TournamentsController extends Controller
{
    public function index()
    {
        $Tournaments = Tournaments::all();
        confirmDelete('Delete Tournament!', 'Are you sure you want to delete this Tournament?');
        return view('Dashboard.Tournaments.index')->with(['Tournaments' => $Tournaments]);
    }
    public function Add()
    {
        $Games = Games::all();
        return view('Dashboard.Tournaments.Add')->with(['Games' => $Games]);
    }
    public function Create(Request $request)
    {
        $request->validate([
            'Name' => 'required|string',
            'Description' => 'required|string',
            'PlayerCount' => 'required|integer',
            'TotalStage' => 'required|integer',
            'Type' => 'required|string|in:Knockout,WorldCup,League',
            'Mode' => 'required|string|in:Free,Paid',
            'Price' => 'required|integer',
            'Time' => 'required|integer',
            'Start' => 'required|date_format:Y-m-d H:i:s',
            'End' => 'required|date_format:Y-m-d H:i:s',
            'GameID' => 'required|integer|exists:games,id',
            'Winners' => 'required|integer',
            'Awards' => 'required|array',
        ]);

        $Tournament = Tournaments::create([
            'Name' => $request->Name,
            'Description' => $request->Description,
            'PlayerCount' => $request->PlayerCount,
            'TotalStage' => $request->TotalStage,
            'LastStage' => 0,
            'Type' => $request->Type,
            'Mode' => $request->Mode,
            'Price' => $request->Price,
            'Time' => $request->Time,
            'Start' => $request->Start,
            'End' => $request->End,
            'GameID' => $request->GameID,
            'Winners' => $request->Winners,
            'Awards' => $request->Awards,
            'Status' => 'Pending',
        ]);

        \Alert::success('Tournament created successfully');


        return redirect()->route('Dashboard.Tournaments.index');
    }

    public function Delete(int $ID)
    {
        $Tournament = Tournaments::find($ID);
        $Tournament->delete();
        Alert::success('Tournament Deleted successfully');
        return redirect()->route('Dashboard.Tournaments.index');

    }
}
