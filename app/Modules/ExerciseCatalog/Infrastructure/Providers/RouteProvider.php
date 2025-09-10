<?php

declare(strict_types=1);

namespace App\Modules\ExerciseCatalog\Infrastructure\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

final class RouteProvider extends RouteServiceProvider
{
    public function boot(): void
    {
        Route::middleware('web')
            ->group(__DIR__ . '/../Routes/web.php');
    }
}
