<?php

use App\Http\Controllers\PostController;
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
    });

require __DIR__.'/auth.php';
