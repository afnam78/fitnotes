<?php

declare(strict_types=1);

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\VoltServiceProvider::class,
    App\Modules\Workout\Infrastructure\Providers\ModuleProvider::class,
    App\Modules\Exercise\Infrastructure\Providers\ModuleProvider::class,
    App\Modules\Calendar\Infrastructure\Providers\ModuleProvider::class,
    App\Modules\Set\Infrastructure\Providers\ModuleProvider::class,
    App\Modules\Shared\Infrastructure\Providers\ModuleProvider::class,
    App\Modules\Backup\Infrastructure\Providers\ModuleProvider::class,
];
