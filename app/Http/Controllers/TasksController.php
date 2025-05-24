<?php

namespace App\Http\Controllers;

use App\Http\Traits\Uploader;
use App\Models\Tasks;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TasksController extends Controller
{
    use Uploader;

    public function index()
    {
        $Tasks = Tasks::all();
        confirmDelete('Delete Task !', 'Are you sure you want to delete this Task?');
        return view('Dashboard.Tasks.index')->with(['Tasks' => $Tasks]);
    }
    public function Add()
    {
        return view('Dashboard.Tasks.Add');

    }

    public function Edit(int $ID)
    {
        $Task = Tasks::find($ID);
        return view('Dashboard.Tasks.Edit')->with([ 'Task' => $Task]);
    }

    public function Update(int $ID , Request $request)
    {
        $request->validate([
            'TaskID' => 'required|string',
            'Name' => 'required|string',
            'Description' => 'required|string',
            'Image' => 'nullable|file|image',
            'Category' => 'required|string',
            'Condition' => 'required|string',
            'Reward' => 'required|string',
        ]);
        $Task = Tasks::find($ID);


        if($request->hasFile('Image')){
            $AttachmentAddress = $this->UploadImage($request->Image , 'Tasks');
        }else{
            $AttachmentAddress = $Task->Image;
        }

        $Task->update([
            'TaskID' => $request->TaskID,
            'Name' => $request->Name,
            'Description' => $request->Description,
            'Image' => $AttachmentAddress,
            'Category' => $request->Category,
            'Condition' => $request->Condition,
            'Reward' => $request->Reward,

        ]);

        Alert::success('Task Updated successfully');

        return redirect()->route('Dashboard.Tasks.index');

    }
    public function Delete(int $ID)
    {
        $Task = Tasks::find($ID);
        $Task->delete();
        Alert::success('Task Deleted successfully');
        return redirect()->route('Dashboard.Tasks.index');

    }
    public function Create(Request $request)
    {
        $request->validate([
            'TaskID' => 'required|string',
            'Name' => 'required|string',
            'Description' => 'required|string',
            'Image' => 'required|file|image',
            'Category' => 'required|string',
            'Condition' => 'required|string',
            'Reward' => 'required|string',
        ]);
        $AttachmentAddress = $this->UploadImage($request->Image , 'Tasks');

        $Task = Tasks::create([
            'TaskID' => $request->TaskID,
            'Name' => $request->Name,
            'Description' => $request->Description,
            'Image' => $AttachmentAddress,
            'Category' => $request->Category,
            'Condition' => $request->Condition,
            'Reward' => $request->Reward,
        ]);
        Alert::success('Task created successfully');


        return redirect()->route('Dashboard.Tasks.index');

    }
}
