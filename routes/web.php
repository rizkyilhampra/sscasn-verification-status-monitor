<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserRequestHeaderController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::controller(AuthenticatedSessionController::class)
        ->group(function () {
            Route::get('/login', 'create')
                ->name('login');
            Route::post('/login', 'store')
                ->middleware('throttle:login');
            Route::delete('/logout', 'destroy')
                ->name('logout');
        });

    Route::controller(RegisteredUserController::class)
        ->group(function () {
            Route::get('/register', 'create')
                ->name('register');
            Route::post('/register', 'store');
        });
});

Route::controller(UserRequestHeaderController::class)
    ->middleware('auth')
    ->name('user-request-headers.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{userRequestHeader}', 'edit')->name('edit');
        Route::put('/{userRequestHeader}', 'update')->name('update');
        Route::delete('/{userRequestHeader}', 'destroy')->name('destroy');
    });
