<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIs\AuthController;
use App\Http\Controllers\APIs\KeyController;
use App\Http\Controllers\APIs\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group( function () {
    
    // key API    
    Route::post('/key', [KeyController::class, 'key']);
    Route::post('/keyVerify', [KeyController::class, 'keyVerify']);
    Route::post('/updateOrderCount', [KeyController::class, 'updateOrderCount']);

    // user adding api
    Route::post('/user', [UserController::class, 'user']);
});