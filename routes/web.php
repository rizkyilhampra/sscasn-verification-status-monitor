<?php

use App\Http\Controllers\VerificationStatusController;
use Illuminate\Support\Facades\Route;

Route::controller(VerificationStatusController::class)
    ->middleware('auth')
    ->name('verification-status.')
    ->group(function () {
        Route::get('/', 'index')->name('verification-status');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{verificationStatus}', 'edit')->name('edit');
        Route::put('/{verificationStatus}', 'update')->name('update');
        Route::delete('/{verificationStatus}', 'destroy')->name('destroy');
    });

require __DIR__.'/auth.php';
