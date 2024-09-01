<?php

use App\Livewire\Home\Home;
use App\Livewire\Home\CurriculumVitae;
use App\Livewire\Home\Interview;
use App\Livewire\Home\Jobs;
use App\Livewire\User\Password;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\PositionChosen;

Route::middleware('auth')->group(function () {
    Route::get('/', Home::class)
        ->name('home');

    Route::middleware([PositionChosen::class])->group(function () {
        Route::get('/cv-analysis', CurriculumVitae::class)
            ->name('cv');

        Route::get('/interview', Interview::class)
            ->name('interview');

        Route::get('/jobs', Jobs::class)
            ->name('jobs');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', Password::class)
            ->name('user.password');
    });
});
