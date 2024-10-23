<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

    

Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::controller(PostController::class)
            ->group(function () {
                Route::get('/posts','index')
                    ->name('post.index');
                Route::post('/post','store')
                    ->name('post.store');
            });

        Route::controller(UserController::class)
            ->group(function() {
                Route::get('/users', 'index')
                    ->name('users.index');
            });
    });

require __DIR__.'/auth.php';
