<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Infrastructure\Providers;

use App\Modules\Calendar\Domain\Contracts\EventRepositoryInterface;
use App\Modules\Calendar\Domain\Contracts\WorkoutRepositoryInterface;
use App\Modules\Calendar\Infrastructure\Repositories\EventRepository;
use App\Modules\Calendar\Infrastructure\Repositories\WorkoutRepository;
use Illuminate\Support\ServiceProvider;

final class ModuleProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../Presentation/Views', 'calendar');
    }

    public function register(): void
    {
        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
        $this->app->bind(WorkoutRepositoryInterface::class, WorkoutRepository::class);
    }
}
