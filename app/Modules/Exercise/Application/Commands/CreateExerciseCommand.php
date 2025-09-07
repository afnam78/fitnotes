<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Application\Commands;

final readonly class CreateExerciseCommand
{
    public function __construct(
        public string $name,
        public int $workoutId,
        public int $userId,
        public ?string $description = null,
    ) {

    }
}
