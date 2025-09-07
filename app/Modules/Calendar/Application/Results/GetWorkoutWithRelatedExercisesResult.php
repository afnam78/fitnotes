<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\Results;

use App\Modules\Calendar\Application\DTOs\WorkoutWithRelatedExercises\ExerciseDTO;

final class GetWorkoutWithRelatedExercisesResult
{
    public function __construct(
        public int $workoutId,
        public string $workoutName,
        public array $exercises, // Array of ExerciseDTO
    ) {
    }

    public function toArray(): array
    {
        return [
            'workout_id' => $this->workoutId,
            'workout_name' => $this->workoutName,
            'exercises' => array_map(fn (ExerciseDTO $exercise) => $exercise->toArray(), $this->exercises),
        ];
    }
}
