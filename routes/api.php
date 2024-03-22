<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Projects\ProjectController;
use App\Http\Controllers\Tasks\TaskController;
use App\Http\Controllers\Users\UserController;
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

Route::post('/users', [UserController::class, 'store']);
Route::get('/confirm-email/{token}', [AuthController::class, 'confirmEmail'])->name('confirm-email');
Route::post('/users/login', [AuthController::class, 'login']);



Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/users/logout', [AuthController::class, 'logout']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user_id}', [UserController::class, 'show']);
    Route::match(['put', 'patch'], '/users/{user_id}', [UserController::class, 'update']);
    Route::delete('users/{user_id}', [UserController::class, 'destroy']);

    Route::post('users/{user_id}/projects', [ProjectController::class, 'store']);
    Route::get('users/{user_id}/projects', [ProjectController::class, 'index']);
    Route::get('users/{user_id}/projects/{project_id}', [ProjectController::class, 'show']);
    Route::match(['put', 'patch'], 'users/{user_id}/projects/{project_id}', [ProjectController::class, 'update']);
    Route::delete('users/{user_id}/projects/{project_id}', [ProjectController::class, 'destroy']);
    Route::post('users/{user_id}/projects/{project_id}/add-member', [ProjectController::class, 'addMember']);

    Route::post('users/{user_id}/projects/{project_id}/tasks', [TaskController::class, 'store']);
    Route::get('users/{user_id}/projects/{project_id}/tasks', [TaskController::class, 'index']);
    Route::get('users/{user_id}/projects/{project_id}/tasks/{task_id}', [TaskController::class, 'show']);
    Route::match(['put', 'patch'], 'users/{user_id}/projects/{project_id}/tasks/{task_id}', [TaskController::class, 'update']);
    Route::delete('users/{user_id}/projects/{project_id}/tasks/{task_id}', [TaskController::class, 'destroy']);
});



