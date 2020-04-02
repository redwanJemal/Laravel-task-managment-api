<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;

class DepartmentsController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $department = Department::paginate($request->per_page);
        return response()->json($department, 200);

    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:departments,name',
        ]);
        $admin = User::isAdmin()->where('id','=',$request->user()->id)->first();
        if($admin){
            $department = Department::create($request->all());
            return response()->json($department, 200);
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
    public function show(Department $department)
    {
        //
        return response()->json($department, 200);
    }

    /**
     * Update the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, Department $department)
    {
        //
        $request->validate([
            'name' => 'required|unique:departments,name',
        ]);
        $department->update($request->all());
        return response()->json($department,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Department $department)
    {
        //
        $department->delete();
        return response()->json(null,204);
    }

    // Department Users
    public function users($id, Request $request){
        $department = Department::where('id','=',$id)->first();
        if(!$department){
            return response()->json(['users'=>[]], 200);
        }
        $users = $department->users()->paginate($request->per_page);
        return response()->json($users, 200);
    }
}
