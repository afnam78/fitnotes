<?php

declare(strict_types=1);

namespace App\Modules\Shared\Application\Commands;

final class GetDashboardKPICommand
{
    public function __construct(
        public int $userId,
    ) {
    }
}
