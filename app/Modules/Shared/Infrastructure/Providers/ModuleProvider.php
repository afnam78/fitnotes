<?php

declare(strict_types=1);

namespace App\Modules\Shared\Infrastructure\Providers;

use App\Modules\Shared\Domain\Contracts\DashboardRepositoryInterface;
use App\Modules\Shared\Infrastructure\Repositories\DashboardRepository;
use Illuminate\Support\ServiceProvider;

final class ModuleProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../Presentation/Views', 'shared');
    }

    public function register(): void
    {
        $this->app->bind(DashboardRepositoryInterface::class, DashboardRepository::class);
    }
}
