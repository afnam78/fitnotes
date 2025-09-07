<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Application\Commands;

final readonly class GetExerciseDetailsCommand
{
    public function __construct(
        public int $exerciseId,
        public int $userId,
    ) {
    }
}
