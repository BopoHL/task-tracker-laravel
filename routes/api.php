<?php

use App\Http\Controllers\RegisterLogin\RegisterLoginController;
use App\Http\Controllers\Projects\ProjectController;
use App\Http\Controllers\Tasks\TaskController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;


// Registration/login
Route::post('/register', [RegisterLoginController::class, 'register']);
Route::get('/confirm-email/{token}', [RegisterLoginController::class, 'confirmUserEmail'])->name('confirm-email');
Route::post('/login', [RegisterLoginController::class, 'login']);
Route::post('/logout', [RegisterLoginController::class, 'logout'])->middleware(['auth:sanctum']);

// User
Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/me', [UserController::class, 'me']);
    Route::match(['put', 'patch'], '/me', [UserController::class, 'updateMe']);

});

// Projects
Route::prefix('/projects')->middleware(['auth:sanctum'])->group(function () {

    Route::post('/', [ProjectController::class, 'store']);
    Route::get('/{project_id}', [ProjectController::class, 'show']);
    Route::match(['put', 'patch'], '/{project_id}', [ProjectController::class, 'update']);
    Route::delete('/{project_id}', [ProjectController::class, 'destroy']);
    Route::get('/', [ProjectController::class, 'index']);
    Route::post('/{project_id}/users', [ProjectController::class, 'addMember']);

    //Tasks
    Route::post('/{project_id}/tasks', [TaskController::class, 'store']);
    Route::match(['put', 'patch'], '/{project_id}/tasks/{task_id}', [TaskController::class, 'update']);
    Route::get('/{project_id}/tasks', [TaskController::class, 'index']);
    Route::get('/{project_id}/tasks/{task_id}', [TaskController::class, 'show']);
    Route::delete('/{project_id}/tasks/{task_id}', [TaskController::class, 'destroy']);
    Route::post('/{project_id}/tasks/{task_id}/users', [TaskController::class, 'addAssigner']);

});
