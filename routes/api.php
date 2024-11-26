<?php

use App\Http\Controllers\InterestController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

    

Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('/user', function (Request $request) {
            $user = User::find($request->user()->id);
            return $user;
        });

        Route::get('/profile/interests', [InterestController::class, 'index']);

        Route::controller(PostController::class)
            ->group(function () {
                Route::get('/posts', 'index');
                Route::post('/post', 'store');
            });

        Route::controller(UserController::class)
            ->group(function() {
                Route::get('/users', 'index');
                Route::post('/user/follow', 'pair');
                Route::post('/user/update', 'update');
            });

        Route::controller(RoomController::class)
            ->group(function () {
                Route::get('rooms', 'index');
                Route::get('room/{id}', 'show');
            });

        Route::controller(MessageController::class)
            ->group(function () {
                Route::post('message/{room}/store', 'store');
            });
    });

require __DIR__.'/auth.php';
