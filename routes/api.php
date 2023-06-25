<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;

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

//Get department wise employees data
Route::get('/departments', ['App\Http\Controllers\DepartmentController', 'index']);
//API resource route :: Used put update request for employee salary change
Route::resource('employee', 'App\Http\Controllers\EmployeeController');
