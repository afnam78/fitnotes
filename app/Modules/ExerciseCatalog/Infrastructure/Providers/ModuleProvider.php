<?php

declare(strict_types=1);

namespace App\Modules\ExerciseCatalog\Infrastructure\Providers;

use App\Modules\ExerciseCatalog\Domain\Contracts\ExerciseCatalogRepositoryInterface;
use App\Modules\ExerciseCatalog\Infrastructure\Repositories\ExerciseCatalogRepository;
use Illuminate\Support\ServiceProvider;

final class ModuleProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../Presentation/Views', 'exercise-catalog');
    }

    public function register(): void
    {
        $this->app->register(RouteProvider::class);
        $this->app->bind(ExerciseCatalogRepositoryInterface::class, ExerciseCatalogRepository::class);
    }
}
