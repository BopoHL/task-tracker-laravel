<?php

use App\Http\Controllers\RegisterLogin\RegisterLoginController;
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

Route::post('/register', [RegisterLoginController::class, 'register']);
Route::get('/confirm-email/{token}', [RegisterLoginController::class, 'confirmUserEmail'])->name('confirm-email');
Route::post('/login', [RegisterLoginController::class, 'login']);
Route::post('/logout', [RegisterLoginController::class, 'logout'])->middleware(['auth:sanctum']);

Route::prefix('/users')->middleware(['auth:sanctum'])->group(function () {

Route::get('/', [UserController::class, 'show']);
Route::match(['put', 'patch'], '/', [UserController::class, 'update']);
Route::delete('/', [UserController::class, 'destroy']);
Route::get('/search', [UserController::class, 'index']);

});

Route::prefix('/projects')->middleware(['auth:sanctum'])->group(function () {

Route::post('/create', [ProjectController::class, 'store']);
Route::get('/show', [ProjectController::class, 'show']);
Route::match(['put', 'patch'], '/update', [ProjectController::class, 'update']);
Route::delete('/delete', [ProjectController::class, 'destroy']);
Route::get('/search', [ProjectController::class, 'index']);
Route::post('/add-member', [ProjectController::class, 'addMember']);

});

Route::prefix('/tasks')->middleware(['auth:sanctum'])->group(function () {

Route::post('/create', [TaskController::class, 'store']);
Route::get('/show', [TaskController::class, 'show']);
Route::match(['put', 'patch'], '/update', [TaskController::class, 'update']);
Route::delete('/delete', [TaskController::class, 'destroy']);
Route::get('/search', [TaskController::class, 'index']);
Route::post('/add-member', [TaskController::class, 'addMember']);

});





