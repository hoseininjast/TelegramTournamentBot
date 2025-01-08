<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        $Games = Games::all();
        return view('Dashboard.Games.index')->with(['Games' => $Games]);
    }
    public function Add()
    {
        return view('Dashboard.Games.Add');

    }
    public function Create(Request $request)
    {
        $request->validate([
            'Name' => 'required|string',
            'Description' => 'required|string',
            'Image' => 'required|file|image',
        ]);
        $AttachmentAddress = $this->UploadImage($request->Image , 'Games');

        $Game = Games::create([
            'Name' => $request->Name,
            'Description' => $request->Description,
            'Image' => $AttachmentAddress,
        ]);
        Alert::success('Game created successfully');


        return redirect()->route('Dashboard.Games.index');

    }
}
