<?php

declare(strict_types=1);

namespace App\Modules\Workout\Application\Commands;

final readonly class DeleteWorkoutCommand
{
    public function __construct(
        public int $workoutId,
        public int $userId,
    ) {
    }
}
