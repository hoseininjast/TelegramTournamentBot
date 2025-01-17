<?php

namespace App\Http\Controllers;

class WebController extends Controller
{
    public function index()
    {
        return view('Dashboard.index');
    }
    public function GotoDashboard()
    {
        return redirect()->route('Dashboard.index');
    }
}
