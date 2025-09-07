<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Application\Commands;

final readonly class UpdateExerciseCommand
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $description,
        public int $workoutId,
        public int $userId,
    ) {
    }
}
