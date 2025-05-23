<?php

namespace App\Http\Controllers;

use App\Http\Traits\Uploader;
use App\Jobs\NotifyAllTelegramUsersJob;
use App\Models\TimeTable;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TimeTableController extends Controller
{
    use Uploader;
    public function index()
    {
        $TimeTable = TimeTable::first();
        return view('Dashboard.TimeTable.index')->with(['TimeTable' => $TimeTable]);
    }
    public function Update( Request $request )
    {
        $request->validate([
            'Image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);


        if ($request->hasFile('Image')) {
            $TimeTable = TimeTable::first();
            $AttachmentAddress = $this->UploadImage($request->Image , 'TimeTable');
            $TimeTable->update([
                'Image' => $AttachmentAddress
            ]);
            $text = 'Time Table Updated , go and see new tournament plans.';
            if(env('APP_ENV') == 'production'){
                NotifyAllTelegramUsersJob::dispatch($text);
            }
            Alert::success('Time Table Updated successfully');
        }else{
            Alert::error('Please Upload image');
        }
        return redirect()->back();
    }
}
