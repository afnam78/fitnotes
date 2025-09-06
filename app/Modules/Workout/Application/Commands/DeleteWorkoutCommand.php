<?php

namespace App\Modules\Workout\Application\Commands;

readonly class DeleteWorkoutCommand
{
    public function __construct(
        public int $workoutId,
        public int $userId,
    ) {
    }
}
