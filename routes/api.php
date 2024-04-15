<?php

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

Route::group(['prefix' => 'auth'] ,function () {
    Route::post('login',[\App\Http\Controllers\Api\AuthController::class,'login']);
    Route::post('logout',[\App\Http\Controllers\Api\AuthController::class,'logout'])
        ->middleware('auth:sanctum');
});

Route::group([
    'middleware' => 'auth:sanctum',
],function () {
    Route::apiResource('users', \App\Http\Controllers\Api\UserController::class)
        ->only('index','edit','update','destroy');
});


