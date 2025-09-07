<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Application\Commands;

final readonly class DeleteExerciseCommand
{
    public function __construct(
        public int $id,
        public int $userId,
    ) {
    }
}
