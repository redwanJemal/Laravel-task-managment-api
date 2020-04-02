<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;

class AdminController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'user_name' => 'required|unique:departments,name',
            'first_name' => 'required',
            'password' => 'required',
            'department_id' => 'required',
            'email' => 'required|unique:users,email',
        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $department = Department::create($input);
        return response()->json($department, 200, $headers);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function assign_role(Request $request)
    {
        $admin = User::isAdmin()->where('id','=',$request->user()->id)->first();
        if($admin){
                $user = User::where('id','=',$request->user_id)
                      ->update(['role_id' => $request->role_id]);
                return response()->json($user, 204);
        }
        else{
            return response()->json('Bad Request', 400);
        }
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
   public function project_managers(Request $request)
   {
       //
       return response()->json(User::projectManagers()->paginate($request->per_page), 200);
   }

   /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function admins(Request $request)
  {
      //
      return response()->json(User::Admins()->paginate($request->per_page), 200);
  }

  /**
  * Display a listing of the resource.
  *
  * @return Response
  */
 public function staffs(Request $request)
 {
     //
     return response()->json(User::staffs()->paginate($request->per_page), 200);
 }
}
