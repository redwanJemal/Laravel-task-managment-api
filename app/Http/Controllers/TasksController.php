<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $task = Task::paginate($request->per_page);
        return response()->json($task, 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        $input = $request->all();
        $input['created_by'] = $request->user()->id;
        $projectManager = User::projectManager()->where('id','=',$request->user()->id)->first();
        if($projectManager){
            $task = Task::create($input);
            return response()->json($task, 200);
        }
        else{
            return response()->json('Bad Request', 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Task $Task)
    {
        //
        return response()->json($Task, 200);
    }

    /**
     * Update the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, Task $task)
    {
        //
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        if($task->created_by != $request->user()->id){
            return response()->json('Bad Request', 400);
        }
        $task->update($request->all());
        return response()->json($task,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Task $task,Request $request)
    {
        if($task->created_by != $request->user()->id){
            return response()->json('Bad Request', 400);
        }
        $task->delete();
        return response()->json(null,204);
    }
}
