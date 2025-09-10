<?php

declare(strict_types=1);

use App\Modules\WorkoutCategory\Presentation\Livewire\Create;
use App\Modules\WorkoutCategory\Presentation\Livewire\Table;
use App\Modules\WorkoutCategory\Presentation\Livewire\Update;
use Illuminate\Support\Facades\Route;

Route::prefix('workout-categories')->middleware(['auth'])->group(function (): void {
    Route::get('', Table::class)
        ->name('workout-category');

    Route::get('create', Create::class)
        ->name('workout-category.create');

    Route::get('update/{id}', Update::class)
        ->name('workout-category.update')
        ->where('workout', '[0-9]+');
});
