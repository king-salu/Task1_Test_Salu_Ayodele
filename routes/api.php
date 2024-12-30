<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\brtController;
use App\Http\Controllers\userController;
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

Route::post('/register', [userController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/brts/stats', [brtController::class, 'data_analysis']);

Route::middleware('protect')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/brts', [brtController::class, 'store']);
    Route::get('/brts', [brtController::class, 'index']);
    Route::get('/brts/{id}', [brtController::class, 'show']);
    Route::put('/brts/{id}', [brtController::class, 'update']);
    Route::delete('/brts/{id}', [brtController::class, 'destroy']);
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
