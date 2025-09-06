<?php

use App\Livewire\Calendar;
use App\Livewire\Exercise\Create;
use App\Livewire\Exercise\Register;
use App\Livewire\Exercise\Table;
use App\Livewire\Exercise\Update;
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

Route::prefix('exercise')->middleware(['auth'])->group(function () {
    Route::get('', Table::class)
        ->name('exercise');

    Route::get('create', Create::class)
        ->name('exercise.create');

    Route::get('update/{exercise}', Update::class)
        ->name('exercise.update')
        ->where('exercise', '[0-9]+');

    Route::get('register/{date?}', Register::class)
        ->name('exercise.register')
        ->where('exercise', '[0-9]+');
});


Route::get('calendar', Calendar::class)
    ->name('calendar')
    ->middleware('auth');

require __DIR__.'/auth.php';
