<?php

use App\Livewire\Workout;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::prefix('workout')->middleware(['auth'])->group(function () {
    Route::get('', Workout\Table::class)
        ->name('workout');

    Route::get('create', Workout\Create::class)
        ->name('workout.create');

    Route::get('update/{workout}', Workout\Update::class)
        ->name('workout.update')
        ->where('workout', '[0-9]+');
});

require __DIR__.'/auth.php';
