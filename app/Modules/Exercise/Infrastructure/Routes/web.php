<?php

declare(strict_types=1);


use App\Modules\Exercise\Presentation\Livewire\Create;
use App\Modules\Exercise\Presentation\Livewire\Table;
use App\Modules\Exercise\Presentation\Livewire\Update;
use Illuminate\Support\Facades\Route;

Route::prefix('exercise')->middleware(['auth'])->group(function (): void {
    Route::get('', Table::class)
        ->name('exercise');

    Route::get('create', Create::class)
        ->name('exercise.create');

    Route::get('update/{id}', Update::class)
        ->name('exercise.update')
        ->where('exercise', '[0-9]+');
});
