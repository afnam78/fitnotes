<?php

declare(strict_types=1);

namespace App\Modules\Shared\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;

final class ModuleProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../Presentation/Views', 'shared');
    }
}
