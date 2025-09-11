<?php

declare(strict_types=1);

use App\Modules\Calendar\Presentation\Livewire\Calendar;
use App\Modules\Shared\Infrastructure\Middleware\LandingPageMiddleware;
use App\Modules\Shared\Presentation\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->middleware(LandingPageMiddleware::class);

Route::get('dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::get('calendar', Calendar::class)
    ->name('calendar')
    ->middleware('auth');

Route::get('backup-import', App\Modules\Backup\Presentation\Livewire\BackupImport::class)
    ->name('backup.import')
    ->middleware('auth');

require __DIR__ . '/auth.php';
