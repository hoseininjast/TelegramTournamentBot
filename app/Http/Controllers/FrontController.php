<?php

namespace App\Http\Controllers;

use App\Models\Games;

class FrontController extends Controller
{
    public function index()
    {
        return redirect()->route('Front.Games');
    }
    public function Games()
    {
        $Games = Games::all();
        return view('Front.Games.index')->with('Games', $Games);
    }
}
