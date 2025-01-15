<?php

namespace App\Http\Controllers;

use App\Http\Traits\Uploader;
use App\Models\TelegramUsers;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    use Uploader;

    public function index()
    {
        if(\Auth::user()->Role == 'Owner'){
            $Users = User::all();
        }else{
            $Users = User::where('AdminID' , \Auth::id())->get();
        }
        confirmDelete('Delete User!', 'Are you sure you want to delete this user?');
        return view('Dashboard.Users.index')->with(['Users' => $Users]);
    }
    public function Telegram()
    {
        $Users = TelegramUsers::all();
        confirmDelete('Delete User!', 'Are you sure you want to delete this user?');
        return view('Dashboard.Users.Telegram')->with(['Users' => $Users]);
    }
    public function Add()
    {
        $Admins = User::whereIn('Role' ,['Owner' , 'Admin'] )->get(['id' , 'Username']);
        return view('Dashboard.Users.Add')->with(['Admins' => $Admins]);

    }
    public function Create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'Username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'Role' => 'required|string|in:Admin,Supervisor,User',
            'AdminID' => 'required|integer|exists:users,id',
            'password' => 'required|string',
            'WalletAddress' => 'nullable|string|regex:/^(0x)?(?i:[0-9a-f]){40}$/',
        ]);

        User::create([
            'name' => $request->name,
            'Username' => $request->Username,
            'email' => $request->email,
            'Role' => $request->Role,
            'AdminID' => $request->AdminID,
            'password' => \Hash::make($request->password),
            'WalletAddress' => $request->WalletAddress,
            'Image' => 'https://platotournament.ai1polaris.com/images/Users/DefaultProfile.png',
        ]);

        Alert::success('User created successfully');


        return redirect()->route('Dashboard.Users.index');

    }

    public function Delete(int $ID)
    {
        $User = User::find($ID);
        $User->delete();
        Alert::success('User Deleted successfully');
        return redirect()->route('Dashboard.Users.index');

    }

    public function TelegramDelete(int $ID)
    {
        $User = TelegramUsers::find($ID);
        $User->delete();
        Alert::success('User Deleted successfully');
        return redirect()->route('Dashboard.Users.Telegram');

    }


    public function Setting()
    {
        return view('Dashboard.Users.Profile.index');
    }

    public function Update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'TelegramUserID' => 'nullable|integer',
            'WalletAddress' => 'nullable|string|regex:/^(0x)?(?i:[0-9a-f]){40}$/|unique:users,WalletAddress,' . \Auth::id(),
            'PlatoID' => 'nullable|string',
            'password' => 'nullable|string',
            'Image' => 'nullable|file',

        ]);
        $User = \Auth::user();

        if($request->hasFile('Image')){
            $ProfileImage = $this->UploadImage($request->Image , 'Users/Profile');
        }else{
            $ProfileImage = $User->Image;
        }

        $User->update([
            'name' => $request->name,
            'TelegramUserID' => $request->TelegramUserID,
            'WalletAddress' => $request->WalletAddress,
            'PlatoID' => $request->PlatoID,
            'Image' => $ProfileImage,
        ]);

        if($request->has('password')){
            $password = \Hash::make($request->password);
            $User->update([
                'password' => $password,
            ]);
        }


        Alert::success('Profile updated successfully');


        return redirect()->route('Dashboard.Profile.Setting');
    }
}
