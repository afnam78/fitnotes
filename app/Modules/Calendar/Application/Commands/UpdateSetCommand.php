<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\Commands;

final readonly class UpdateSetCommand
{
    public function __construct(
        public int $setId,
        public int $userId,
        public int $reps,
        public float $weight,
    ) {
    }
}
