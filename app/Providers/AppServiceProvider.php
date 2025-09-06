<?php

declare(strict_types=1);

namespace App\Providers;

use App\Modules\Workout\Infrastructure\Providers\ModuleProvider;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Workout any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


        $this->register(ModuleProvider::class);
    }
}
