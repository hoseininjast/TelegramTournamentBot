<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ReferralPlan;
use App\Models\ReferralPlanHistory;
use App\Models\Tasks;
use App\Models\TelegramUsers;
use App\Models\UserTasks;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function List()
    {
        $Tasks = Tasks::all();


        return response()->json([
            'Data' => [
                'Tasks' => $Tasks,
                'Code' => 200,
            ],
        ], 200);
    }
    public function Check(Request $request)
    {
        $request->validate([
            'TaskID' => 'required|integer|exists:tasks,id',
            'UserID' => 'required|integer|exists:telegram_users,id',
        ]);

        $Task = Tasks::find($request->TaskID);
        $User = TelegramUsers::find($request->UserID);


        $TaskStatus = UserTasks::where([
            ['TaskID' , $Task->id],
            ['UserID' , $User->id],
        ])->count();

        if ($TaskStatus > 0) {
            return response()->json([
                'Data' => [
                    'Status' => true,
                    'Code' => 200,
                ],
            ], 200);
        }else{
            return response()->json([
                'Data' => [
                    'Status' => false,
                    'Code' => 400,
                ],
            ], 200);
        }


    }
}
