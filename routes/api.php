<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Task;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$middleware = 'auth:api';
// Auth Controller
Route::post('auth/register', 'AuthController@register');
Route::post('auth/login', 'AuthController@login');
Route::middleware('auth:api')->get('auth/logout', 'AuthController@logout');


// Department
Route::middleware('auth:api')->post('department/create', 'DepartmentsController@store');
Route::middleware('auth:api')->post('department/update/{department}', 'DepartmentsController@update');
Route::middleware('auth:api')->get('department/{department}', 'DepartmentsController@show');
Route::middleware('auth:api')->get('department/{department}/users', 'DepartmentsController@users');
Route::middleware('auth:api')->get('departments', 'DepartmentsController@index');
Route::middleware('auth:api')->delete('department/delete/{department}', 'DepartmentsController@destroy');

// Admin
Route::middleware('auth:api')->post('admin/assign_role', 'AdminController@assign_role');

// Users
Route::middleware($middleware)->get('users/admin','AdminController@admins');
Route::middleware($middleware)->get('users/staffs','AdminController@staffs');
Route::middleware($middleware)->get('users/project_managers','AdminController@project_managers');
Route::middleware($middleware)->get('user/{user}','UsersController@show');
Route::middleware($middleware)->post('user/update/{user}','UsersController@update');
Route::middleware($middleware)->get('users','UsersController@users');

Route::middleware($middleware)->get('user/{user}/my_tasks','UsersController@my_tasks');
Route::middleware($middleware)->get('user/{user}/completed_tasks','UsersController@completed_tasks');
Route::middleware($middleware)->get('user/{user}/in_completed_tasks','UsersController@in_completed_tasks');
Route::middleware($middleware)->post('user/{user}/task/{task}/complete','UsersController@complete_task');
Route::middleware($middleware)->post('user/{user}/task/{task}/start','UsersController@start_task');


// Manager
Route::middleware($middleware)->get('project_managers/users','ProjectManagersController@department_staffs');
Route::middleware('auth:api')->post('project_managers/{task}/assign', 'ProjectManagersController@assign_task');
// Tasks
Route::middleware('auth:api')->post('project_managers/task/create', 'TasksController@store');
Route::middleware('auth:api')->get('project_managers/task/{task}', 'TasksController@show');
Route::middleware('auth:api')->post('project_managers/task/update/{task}', 'TasksController@update');
Route::middleware('auth:api')->delete('project_managers/task/delete/{task}', 'TasksController@destroy');



