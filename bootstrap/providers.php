<?php

declare(strict_types=1);

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\VoltServiceProvider::class,
    App\Modules\WorkoutCategory\Infrastructure\Providers\ModuleProvider::class,
    App\Modules\ExerciseCatalog\Infrastructure\Providers\ModuleProvider::class,
    App\Modules\Calendar\Infrastructure\Providers\ModuleProvider::class,
    App\Modules\Set\Infrastructure\Providers\ModuleProvider::class,
    App\Modules\Shared\Infrastructure\Providers\ModuleProvider::class,
];
