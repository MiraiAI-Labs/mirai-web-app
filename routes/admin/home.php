<?php

use App\Livewire\User\Import;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth', 'role:admin']], function () {
    // Route::prefix('user')->group(function () {
    //     Route::get('/import', Import::class)
    //         ->name('user.import');
    // });
});
