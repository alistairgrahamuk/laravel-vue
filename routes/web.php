<?php

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('login', [ LoginController::class, 'create' ])->name('login');
Route::post('login', [ LoginController::class, 'store' ]);
Route::post('/logout', [ LoginController::class, 'destroy'])->middleware('auth');

// Authorised
Route::middleware('auth')->group(function () {

    Route::get('/', [HomeController::class, 'index']);

    Route::get('/users', [ UserController::class, 'index']);

    Route::get('/users/create', [ UserController::class, 'showIfUserCanCreate' ]);

    Route::get('/users/{id}/edit', [ UserController::class, 'edit' ]);

    Route::post('/users/{id}/edit', [ UserController::class, 'store' ]);

    Route::post('/users', [ UserController::class, 'create' ]);

    Route::get('/settings', [SettingsController::class, 'index']);

});
