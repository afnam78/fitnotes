<?php

declare(strict_types=1);

use App\Modules\Workout\Presentation\Livewire\Create;
use App\Modules\Workout\Presentation\Livewire\Table;
use App\Modules\Workout\Presentation\Livewire\Update;
use Illuminate\Support\Facades\Route;

Route::prefix('workout')->middleware(['auth'])->group(function (): void {
    Route::get('', Table::class)
        ->name('workout');

    Route::get('create', Create::class)
        ->name('workout.create');

    Route::get('update/{id}', Update::class)
        ->name('workout.update')
        ->where('workout', '[0-9]+');
});
