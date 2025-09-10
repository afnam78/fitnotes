<?php

declare(strict_types=1);

namespace App\Modules\WorkoutCategory\Infrastructure\Providers;

use App\Modules\WorkoutCategory\Domain\Contracts\WorkoutCategoryRepositoryInterface;
use App\Modules\WorkoutCategory\Infrastructure\Repositories\WorkoutCategoryRepository;
use Illuminate\Support\ServiceProvider;

final class ModuleProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../Presentation/Views', 'workout-category');
    }

    public function register(): void
    {
        $this->app->register(RouteProvider::class);

        $this->app->bind(WorkoutCategoryRepositoryInterface::class, WorkoutCategoryRepository::class);
    }
}
