<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/project', function (Request $request) {
//    return $request->user();
//});

Route::get('/confirm-email/{token}', [AuthController::class, 'confirmEmail'])->name('confirm-email');

Route::post('/users', [UserController::class, 'store']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{user_id}', [UserController::class, 'show']);
Route::match(['put', 'patch'], '/users/{user_id}', [UserController::class, 'update']);
Route::delete('users/{user_id}', [UserController::class, 'destroy']);

Route::post('/projects', [ProjectController::class, 'store']);
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{project_id}', [ProjectController::class, 'show']);
Route::match(['put', 'patch'], '/projects/{project_id}', [ProjectController::class, 'update']);
Route::delete('projects/{project_id}', [ProjectController::class, 'destroy']);
Route::post('projects/{project_id}', [ProjectController::class, 'addMember']);

Route::post('/tasks', [TaskController::class, 'store']);
Route::get('/tasks', [TaskController::class, 'index']);
Route::get('/tasks/{task_id}', [TaskController::class, 'show']);
Route::match(['put', 'patch'], 'tasks/{task_id}', [TaskController::class, 'update']);
Route::delete('tasks/{task_id}', [TaskController::class, 'destroy']);



