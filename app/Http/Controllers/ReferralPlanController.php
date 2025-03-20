<?php

namespace App\Http\Controllers;

use App\Http\Traits\Uploader;
use App\Models\ReferralPlan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ReferralPlanController extends Controller
{
    use Uploader;

    public function index()
    {
        $ReferralPlan = ReferralPlan::all();
        confirmDelete('Delete Referral Plan!', 'Are you sure you want to delete this Game?');
        return view('Dashboard.ReferralPlan.index')->with(['ReferralPlan' => $ReferralPlan]);
    }
    public function Add()
    {
        return view('Dashboard.ReferralPlan.Add');

    }

    public function Edit(int $ID)
    {
        $ReferralPlan = ReferralPlan::find($ID);
        return view('Dashboard.ReferralPlan.Edit')->with([ 'ReferralPlan' => $ReferralPlan]);
    }

    public function Update(int $ID , Request $request)
    {
        $request->validate([
            'Name' => 'required|string',
            'Description' => 'required|string',
            'Image' => 'nullable|file|image',
            'Level' => 'required|numeric',
            'Count' => 'required|numeric',
            'Award' => 'required|numeric',
        ]);
        $ReferralPlan = ReferralPlan::find($ID);


        if($request->hasFile('Image')){
            $AttachmentAddress = $this->UploadImage($request->Image , 'ReferralPlan');
        }else{
            $AttachmentAddress = $ReferralPlan->Image;
        }

        $ReferralPlan->update([
            'Name' => $request->Name,
            'Description' => $request->Description,
            'Image' => $AttachmentAddress,
            'Level' => $request->Level,
            'Count' => $request->Count,
            'Award' => $request->Award,

        ]);

        Alert::success('Referral Plan Updated successfully');

        return redirect()->route('Dashboard.ReferralPlan.index');

    }
    public function Delete(int $ID)
    {
        $ReferralPlan = ReferralPlan::find($ID);
        $ReferralPlan->delete();
        Alert::success('Referral Plan Deleted successfully');
        return redirect()->route('Dashboard.ReferralPlan.index');

    }
    public function Create(Request $request)
    {
        $request->validate([
            'Name' => 'required|string',
            'Description' => 'required|string',
            'Image' => 'required|file|image',
            'Level' => 'required|numeric',
            'Count' => 'required|numeric',
            'Award' => 'required|numeric',
        ]);
        $AttachmentAddress = $this->UploadImage($request->Image , 'ReferralPlan');

        $ReferralPlan = ReferralPlan::create([
            'Name' => $request->Name,
            'Description' => $request->Description,
            'Image' => $AttachmentAddress,
            'Level' => $request->Level,
            'Count' => $request->Count,
            'Award' => $request->Award,
        ]);
        Alert::success('Referral Plan created successfully');


        return redirect()->route('Dashboard.ReferralPlan.index');

    }
}
