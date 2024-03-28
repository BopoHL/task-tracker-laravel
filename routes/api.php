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
    Route::get('/{id}', [ProjectController::class, 'show']);
    Route::match(['put', 'patch'], '/{id}', [ProjectController::class, 'update']);
    Route::delete('/{id}', [ProjectController::class, 'destroy']);
    Route::get('/', [ProjectController::class, 'index']);
    Route::post('/{id}/users', [ProjectController::class, 'addMember']);

});

// Tasks
Route::prefix('/tasks')->middleware(['auth:sanctum'])->group(function () {

    Route::post('/', [TaskController::class, 'store']);
    Route::get('/{id}', [TaskController::class, 'show']);
    Route::match(['put', 'patch'], '/{id}', [TaskController::class, 'update']);
    Route::delete('/{id}', [TaskController::class, 'destroy']);
    Route::get('/', [TaskController::class, 'index']);
    Route::post('/{id}/users', [TaskController::class, 'addMember']);

});





