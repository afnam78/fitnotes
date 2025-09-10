<?php

declare(strict_types=1);

namespace App\Modules\WorkoutCategory\Application\Commands;

final readonly class DeleteWorkoutCategoryCommand
{
    public function __construct(
        public int $workoutId,
        public int $userId,
    ) {
    }
}
