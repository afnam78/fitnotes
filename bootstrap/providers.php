<?php

declare(strict_types=1);

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\VoltServiceProvider::class,
    App\Modules\Workout\Infrastructure\Providers\ModuleProvider::class,
];
