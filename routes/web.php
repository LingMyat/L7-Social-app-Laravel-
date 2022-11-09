<?php

use App\Http\Controllers\AdminAccountControllre;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)
->group(function(){
    Route::redirect('/','loginPage');
    Route::get('loginPage','loginPage')->name('auth#loginPage');
    Route::get('registerPage','registerPage')->name('auth#registerPage');
    Route::get('auth/dashBoard','dashBoard')->name('auth#dashboard');
});
//Logout
Route::get('logout',[AuthController::class,'logout'])->name('auth#logout');

Route::middleware([
    'auth:sanctum'
])->group(function () {
    // Admin Panel
    Route::middleware('adminAuth')
    ->group(function(){
        Route::controller(AdminController::class)
        ->prefix('admin')
        ->group(function(){
            Route::get('users/list','userList')->name('admin#userList');
            Route::get('post/list','postList')->name('admin#postList');
            Route::get('post/create/page','postCreatePage')->name('admin#postCreatePage');
            Route::post('post/create','postCreate')->name('admin#postCreate');
            Route::get('post/view/{id}','postView')->name('admin#postView');
            Route::get('post/edit/{id}','postEdit')->name('admin#postEdit');
            Route::post('post/update/{id}','postUpdate')->name('admin#postUpdate');
            Route::get('post/delete/{id}','postDelete')->name('admin#postDelete');
        });

        //Admin Account
        Route::controller(AdminAccountControllre::class)
        ->prefix('admin')
        ->group(function(){
            Route::get('profile/{id}','profile')->name('admin#profile');
            Route::post('profile/update/{id}','profileUpdate')->name('admin#profileUpdate');
            Route::post('change/password/{id}','changePassword')->name('admin#changePassword');
        });
    });

    // User Panel
    Route::controller(UserController::class)
    ->prefix('user')
    // Direct Home Page
    ->group(function(){
        Route::get('home','userHome')->name('user#home');
        Route::get('profile/{id}','profile')->name('user#profile');
        Route::post('profile/update{id}','profileUpdate')->name('user#profileUpdate');
        Route::post('change/password/{id}','changePassword')->name('user#changePassword');
        Route::get('addFriend','addFriend');
        Route::get('respondFriend','respondFriend');
        Route::get('confirmFri','confirmFri');
        Route::get('deleteFriReq','deleteFriReq');
        Route::get('unFriend','unFriend');
    });
    // Post Section
    Route::controller(PostController::class)
    ->prefix('post')
    ->group(function(){
        Route::get('create/page','postCreatePage')->name('user#postCreatePage');
        Route::get('view/{id}','postView')->name('user#postView');
        Route::post('create','postCreate')->name('user#postCreate');
        Route::get('edit/{id}','postEdit')->name('user#postEdit');
        Route::post('update/{id}','postUpdate')->name('user#postUpdate');
        Route::get('delete/{id}','postDelete')->name('user#postDelete');
    });
    Route::controller(CommentController::class)
    ->prefix('comment')
    ->group(function(){
        Route::post('create','commentCreate')->name('user#commentCreateComment');
        Route::get('delete','commentDelete');
        Route::post('update/{id}','commentUpdate')->name('user#commentUpdate');
    });
    Route::controller(LikeController::class)
    ->group(function(){
        Route::get('like','like');
        Route::get('unLike','unLike');
    });
    Route::controller(MessageController::class)
    ->prefix('message')
    ->group(function(){
        Route::get('index','index')->name('message#index');
        Route::post('send','sendMessage')->name('message#send');
        Route::get('view/{id}','viewMessage')->name('message#view');
    });
});
