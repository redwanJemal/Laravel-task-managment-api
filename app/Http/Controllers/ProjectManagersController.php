<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;

class ProjectManagersController extends Controller
{
    //

   public function department_staffs(Request $request)
   {
      $department_id = $request->user()->department_id;
      $users = User::staffs()->where('department_id','=',$department_id)->paginate($request->per_page);
      return response()->json($users, 200);
   }


   /**
    * Update the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
   public function assign_task(Request $request, Task $task)
   {
       $request->validate([
           'assigned_user' => 'required',
           'start_date' => 'required',
           'end_date' => 'required',
       ]);
       $input = $request->all();
       $input['status'] = 2; // assigned
       $task->update(['status' => $input['status'],'start_date' => $input['start_date'],'end_date' => $input['end_date'],'assigned_user' => $input['assigned_user']]);
       return response()->json($task,200);
   }
}
