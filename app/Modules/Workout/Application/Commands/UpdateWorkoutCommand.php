<?php

declare(strict_types=1);

namespace App\Modules\Workout\Application\Commands;

final class UpdateWorkoutCommand
{
    public function __construct(
        public int $workoutId,
        public int $userId,
        public string $name,
        public ?string $description = null,
    ) {
    }
}
