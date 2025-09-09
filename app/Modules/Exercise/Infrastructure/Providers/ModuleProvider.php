<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Infrastructure\Providers;

use App\Modules\Exercise\Domain\Contracts\ExerciseRepositoryInterface;
use App\Modules\Exercise\Infrastructure\Repositories\ExerciseRepository;
use Illuminate\Support\ServiceProvider;

final class ModuleProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../Presentation/Views', 'exercise');
    }

    public function register(): void
    {
        $this->app->register(RouteProvider::class);
        $this->app->bind(ExerciseRepositoryInterface::class, ExerciseRepository::class);
    }
}
