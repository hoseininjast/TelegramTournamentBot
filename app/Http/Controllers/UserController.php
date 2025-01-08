<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        $Users = User::all();
        return view('Dashboard.Users.index')->with(['Users' => $Users]);
    }
    public function Add()
    {
        return view('Dashboard.Users.Add');

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
