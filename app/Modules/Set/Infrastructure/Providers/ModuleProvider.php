<?php

declare(strict_types=1);

namespace App\Modules\Set\Infrastructure\Providers;

use App\Modules\Set\Domain\Contracts\SetRepositoryInterface;
use App\Modules\Set\Infrastructure\Repositories\SetRepository;
use Illuminate\Support\ServiceProvider;

final class ModuleProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            SetRepositoryInterface::class,
            SetRepository::class
        );
    }
}
