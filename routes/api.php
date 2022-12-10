<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use app\Http\Middleware\Authenticate;
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
Route::post('/user/register', [App\Http\Controllers\Api\UserController::class, 'register']);
Route::post('/user/login', [App\Http\Controllers\Api\UserController::class, 'login']);
Route::post('/email/password/reset', [App\Http\Controllers\Api\UserController::class, 'emailPassword']);
Route::get('/reset-password/index', [App\Http\Controllers\Api\UserController::class, 'resetPasswordIndex']);
Route::post('/reset-password', [App\Http\Controllers\Api\UserController::class, 'resetPassword']);
Route::get('/view/all/tasks', [App\Http\Controllers\Api\TaskController::class, 'viewAllTasks'])->name('viewallTasks');
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => 'auth:api'], function(){

Route::post('/create/task', [App\Http\Controllers\Api\TaskController::class, 'createTask']);
Route::any('/delete/task/{id}', [App\Http\Controllers\Api\TaskController::class, 'delete'])->name('delete');
Route::any('/show/task/{id}', [App\Http\Controllers\Api\TaskController::class, 'show'])->name('show');
Route::put('/update/task/{id}', [App\Http\Controllers\Api\TaskController::class, 'update'])->name('update');
Route::get('/task/status', [App\Http\Controllers\Api\TaskController::class, 'addStatus']);
Route::post('/update/order', [App\Http\Controllers\Api\TaskController::class, 'updateOrder']);
Route::get('/my/tasks', [App\Http\Controllers\Api\TaskController::class, 'myTasks']);
Route::post('/user/logout', [App\Http\Controllers\Api\UserController::class, 'logout']);
});
