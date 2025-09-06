<?php

namespace App\Modules\Workout\Application\Commands;

class UpdateWorkoutCommand
{
    public function __construct(
        public int $workoutId,
        public int $userId,
        public string $name,
        public ?string $description = null,
    ) {
    }
}
