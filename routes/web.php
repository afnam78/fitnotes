<?php

declare(strict_types=1);

use App\Livewire\Calendar;
use App\Modules\Workout\Presentation\Livewire\Create;
use App\Modules\Workout\Presentation\Livewire\Table;
use App\Modules\Workout\Presentation\Livewire\Update;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::prefix('workout')->middleware(['auth'])->group(function (): void {
    Route::get('', Table::class)
        ->name('workout');

    Route::get('create', Create::class)
        ->name('workout.create');

    Route::get('update/{workout}', Update::class)
        ->name('workout.update')
        ->where('workout', '[0-9]+');
});

Route::prefix('exercise')->middleware(['auth'])->group(function (): void {
    Route::get('', Table::class)
        ->name('exercise');

    Route::get('create', Create::class)
        ->name('exercise.create');

    Route::get('update/{exercise}', Update::class)
        ->name('exercise.update')
        ->where('exercise', '[0-9]+');
});


Route::get('calendar', Calendar::class)
    ->name('calendar')
    ->middleware('auth');

require __DIR__ . '/auth.php';
