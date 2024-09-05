<?php

use App\Livewire\Home\Home;
use App\Livewire\Home\CurriculumVitae;
use App\Livewire\Home\Interview;
use App\Livewire\Home\Jobs;
use App\Livewire\User\Password;
use Illuminate\Support\Facades\Route;
use App\Livewire\Home\Quiz;
use App\Http\Middleware\PositionChosen;

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

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

        Route::get('/quiz', Quiz::class)
            ->name('quiz');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', Password::class)
            ->name('user.password');
    });
});

Route::webhooks('/webhook');
