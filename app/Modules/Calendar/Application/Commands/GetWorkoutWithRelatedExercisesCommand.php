<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\Commands;

final readonly class GetWorkoutWithRelatedExercisesCommand
{
    public function __construct(
        public int $workoutId,
        public int $userId,
    ) {
    }
}
