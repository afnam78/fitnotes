<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Application\Commands;

final readonly class GetUserWorkoutsCommand
{
    public function __construct(
        public int $userId,
    ) {
    }
}
