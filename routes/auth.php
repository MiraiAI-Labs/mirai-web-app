<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)
        ->name('login');
});

Route::middleware('guest')->group(function () {
    Route::get('register', Register::class)
        ->name('register');
});

Route::middleware('auth')->group(function () {
    Route::match(array('GET', 'POST'), 'logout', LogoutController::class)
        ->name('logout');

    Route::view('/', 'welcome')
        ->name('home');
});
