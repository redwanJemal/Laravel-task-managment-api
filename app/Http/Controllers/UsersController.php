<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Task;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function users(Request $request)
    {
        $users = User::paginate($request->per_page);
        return response()->json($users, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(User $user)
    {
        //
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'user_name' => 'unique:users,user_name',
            'password' => 'confirmed',
            'email' => 'unique:users,email',
        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user->update($input);
        return response()->json($user,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(User $user)
    {
        //
        $user->delete();
        return response()->json(null,204);
    }


   /**
    * Start Task
    *
    * @param  int  $id
    * @return Response
    */
    public function end_task(Request $request, Task $task)
    {
        if($task->assigned_user != $request->user()->id){
            return response()->json('Bad Request', 400);
        }
        $request->validate([
            'completed_date' => 'required',
        ]);
        $input = $request->all();
        $input['status'] = 3; // started
        $task->update(['status' => $input['status'],'completed_date' => $input['completed_date']]);
        return response()->json($task,200);
    }
    /**
     * Display Assigned Tasks
     *
     * @return \Illuminate\Http\Response
     */
    public function my_tasks(Request $request,User $user)
    {
        if($user->id != $request->user()->id){
            return response()->json('Bad Request', 400);
        }
        $tasks = $user->tasks()->paginate($request->per_page);
        return response()->json($tasks, 200);

    }


    /**
     * Display Assigned Tasks
     *
     * @return \Illuminate\Http\Response
     */
    public function completed_tasks(Request $request,User $user)
    {
        if($user->id != $request->user()->id){
            return response()->json('Bad Request', 400);
        }
        $tasks = $user->tasks()->where('status','=',4)->paginate($request->per_page);
        return response()->json($tasks, 200);

    }


    /**
     * Display Assigned Tasks
     *
     * @return \Illuminate\Http\Response
     */
    public function in_completed_tasks(Request $request,User $user)
    {
        if($user->id != $request->user()->id){
            return response()->json('Bad Request', 400);
        }
        $tasks = $user->tasks()->where('status','=',3)->orWhere('status','=',2)->paginate($request->per_page);
        return response()->json($tasks, 200);

    }
    /**
     * Complete the specified task.
     *
     * @param  int  $id
     * @return Response
     */
    public function complete_task(Request $request, User $user, Task $task)
    {
        $user_id = $request->user()->id ;
        if($task->assigned_user != $user_id || $user->id != $user_id ){
            return response()->json('Bad Request', 400);
        }
        $task->update(['status' => 4,'completed_date' => now()]);
        return response()->json($task,200);
    }
    /**
     * Complete the specified task.
     *
     * @param  int  $id
     * @return Response
     */
    public function start_task(Request $request, $user_id, $task_id)
    {
        $user = User::find($user_id);
        $task = Task::find($task_id);
        if($task == null || $user == null || $task->assigned_user != $user_id || $user->id != $user_id){
            return response()->json('Bad Request', 400);
        }

        if($task->assigned_user != $user_id || $user->id != $user_id ){
            return response()->json('Bad Request', 400);
        }
        $task->update(['status' => 3,'started_date' => now()]);
        return response()->json($task,200);
    }

}
