<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller
{
    /**
     * Register New User
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request){
        $request->validate([
            'user_name' => 'required|unique:users,user_name',
            'first_name' => 'required',
            'password' => 'required',
            'department_id' => 'required',
            'email' => 'required|unique:users,email',
        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        return response()->json($user, 200);
    }

    /**
     * Login User
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){
        $login = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if(!Auth::attempt($login)){
            return response()->json('Invalid Login Credential', 401);
        }
        $accessToken = Auth::user()->createToken('authToken')->accessToken;
        return response()->json(['user' => Auth::user(),'authToken' => $accessToken], 200);
    }

    /**
     * Login User
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request){
        $token = $request->user()->token();
        $token->revoke();

        return response()->json('Logged Out', 200);
    }
}
