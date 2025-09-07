<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Application\Commands;

final class DeleteExerciseCommand
{
    public function __construct(
        public readonly int $id,
        public readonly int $userId,
    ) {
    }
}
