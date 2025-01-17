<?php

namespace App\Http\Controllers;

use App\Http\Traits\Uploader;
use App\Models\Games;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class GamesController extends Controller
{
    use Uploader;

    public function index()
    {
        $Games = Games::all();
        confirmDelete('Delete Game!', 'Are you sure you want to delete this Game?');
        return view('Dashboard.Games.index')->with(['Games' => $Games]);
    }
    public function Add()
    {
        return view('Dashboard.Games.Add');

    }
    public function Delete(int $ID)
    {
        $Games = Games::find($ID);
        $Games->delete();
        Alert::success('Game Deleted successfully');
        return redirect()->route('Dashboard.Games.index');

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
