<?php

use App\Livewire\Home\Home;
use App\Livewire\Home\CurriculumVitae;
use App\Livewire\Home\Interview;
use App\Livewire\Home\Jobs;
use App\Livewire\User\Password;
use Illuminate\Support\Facades\Route;
use App\Livewire\Home\Quiz;
use App\Http\Middleware\PositionChosen;
use App\Livewire\Home\Roadmap;
use App\Livewire\Home\Welcome;

Route::get('/', Welcome::class)->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/home', Home::class)
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

        Route::get('/roadmap', Roadmap::class)
            ->name('roadmap');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', Password::class)
            ->name('user.password');
    });
});

Route::webhooks('/webhook');
