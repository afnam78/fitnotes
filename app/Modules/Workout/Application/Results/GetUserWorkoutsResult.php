<?php

declare(strict_types=1);

namespace App\Modules\Workout\Application\Results;

use App\Modules\Workout\Application\DTOs\WorkoutDTO;

final class GetUserWorkoutsResult
{
    public function __construct(
        public array $workouts,
    ) {
    }

    public function toArray(): array
    {
        return array_map(fn (WorkoutDTO $workout) => [
            'id' => $workout->id,
            'name' => $workout->name,
            'description' => $workout->description,
        ], $this->workouts);
    }
}
