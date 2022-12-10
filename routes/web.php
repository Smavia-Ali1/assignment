<?php

use App\Http\Controllers\Api\UserController;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [TaskController::class, 'view']);
Route::get('/index', [TaskController::class, 'index']);
Route::get('/my/tasks', [TaskController::class, 'myTasksIndex']);

