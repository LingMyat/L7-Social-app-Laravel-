<?php

use App\Http\Controllers\AdminAccountControllre;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)
->group(function(){
    Route::redirect('/','loginPage')->middleware('userIsAuthenticated');
    Route::get('loginPage','loginPage')->name('auth#loginPage')->middleware('userIsAuthenticated');
    Route::get('registerPage','registerPage')->name('auth#registerPage')->middleware('userIsAuthenticated');
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
        Route::get('cancelRequest/{reciever_id}','cancelRequest')->name('user#cancelRequest');
        Route::get('respondFriend','respondFriend');
        Route::get('confirmFri','confirmFri');
        Route::get('deleteFriReq','deleteFriReq');
        Route::get('unFriend','unFriend');
        Route::get('forget-session','forgetSession');
        Route::get('/messenger/{id}','messengerBlade')->name('user#messenger');
        Route::post('/messenger',"storeMessenger")->name('user#storeMessenger');
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
        Route::get('media/{id}','deleteMediaPhoto')->name('user#deletePostMediaPhoto');
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
        Route::get('/','index')->name('message#index');
        Route::post('send','sendMessage')->name('message#send');
        Route::get('view/{id}','viewMessage')->name('message#view');
        Route::get('sendPage/{id}','messageSendPage')->name('message#sendPage');
        Route::get('delete/{id}','deleteMessage')->name('message#delete');
        Route::get('read','readMessage');
        Route::get('view/message/{id}','viewMyMessage')->name('message#viewMyMessage');
    });

    Route::controller(RoomController::class)
    ->prefix('room')
    ->group(function(){
        Route::get('/','index')->name('room#index');
        Route::post('/store','store')->name('room#store');
        Route::get('/live-chat','liveChat')->name('room#liveChat');
        Route::post('/message','storeMessage')->name('liveChat#storeMessage');
    });

    Route::controller(FriendRequestController::class)
    ->prefix('people')
    ->group(function(){
        Route::get('/','peopleList')->name('people#index');
        Route::post('/add-friend/{id}','addFriend')->name('addFriend');
        Route::post('/cancel-request/{id}','cancelRequest')->name('cancelRequest');
        Route::post('/respond-friend/{id}','respondFriend')->name('respondFriend');
        Route::post('/unfriend/{id}','unfriend')->name('unfriend');
        Route::post('/forget-ment','forgetMent');
    });
});
