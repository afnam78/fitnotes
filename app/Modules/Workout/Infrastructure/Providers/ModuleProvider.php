<?php

declare(strict_types=1);

namespace App\Modules\Workout\Infrastructure\Providers;

use App\Modules\Workout\Domain\Contracts\WorkoutRepositoryInterface;
use App\Modules\Workout\Infrastructure\Repositories\WorkoutRepository;
use Illuminate\Support\ServiceProvider;

final class ModuleProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../Presentation/Views', 'workout');
    }

    public function register(): void
    {
        $this->app->register(RouteProvider::class);

        $this->app->bind(WorkoutRepositoryInterface::class, WorkoutRepository::class);
    }
}
