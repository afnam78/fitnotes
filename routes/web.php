<?php

declare(strict_types=1);

use App\Modules\Shared\Presentation\Livewire\Calendar;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::get('calendar', Calendar::class)
    ->name('calendar')
    ->middleware('auth');

require __DIR__ . '/auth.php';
