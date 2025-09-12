<?php

declare(strict_types=1);

namespace App\Modules\Backup\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;

final class ModuleProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../Presentation/Views', 'backup');
    }
}
