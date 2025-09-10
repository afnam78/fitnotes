<?php

declare(strict_types=1);


use App\Modules\ExerciseCatalog\Presentation\Livewire\Create;
use App\Modules\ExerciseCatalog\Presentation\Livewire\Table;
use App\Modules\ExerciseCatalog\Presentation\Livewire\Update;
use Illuminate\Support\Facades\Route;

Route::prefix('exercise-catalog')->middleware(['auth'])->group(function (): void {
    Route::get('', Table::class)
        ->name('exercise-catalog');

    Route::get('create', Create::class)
        ->name('exercise-catalog.create');

    Route::get('update/{id}', Update::class)
        ->name('exercise-catalog.update')
        ->where('exercise', '[0-9]+');
});
