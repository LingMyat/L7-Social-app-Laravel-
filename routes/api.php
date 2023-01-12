<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\v1\ChatController;
use App\Http\Controllers\Api\v1\RoomController;
use App\Http\Controllers\Api\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::controller(AuthController::class)
->prefix('auth')
->group(function(){
    Route::post('login','login');
    Route::post('logout','logout')->middleware('auth:api');
});

Route::prefix('v1')
->middleware('auth:api')
->group(function(){
    Route::controller(RoomController::class)->group(function(){
        Route::get('rooms','index');
        Route::get('room-messages','roomMessages');
        Route::post('store-room-message','storeRoomMessage');
    });

    Route::controller(UserController::class)->group(function(){
        Route::get('friends','friends');
    });

    Route::controller(ChatController::class)->group(function(){
        Route::get('messenger','messenger');
        Route::post('store-message','storeMessage');
    });

});


