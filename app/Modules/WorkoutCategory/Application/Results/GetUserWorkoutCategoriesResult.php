<?php

declare(strict_types=1);

namespace App\Modules\WorkoutCategory\Application\Results;

use App\Modules\WorkoutCategory\Application\DTOs\WorkoutCategoryDTO;

final class GetUserWorkoutCategoriesResult
{
    public function __construct(
        public array $workouts,
    ) {
    }

    public function toArray(): array
    {
        return array_map(fn (WorkoutCategoryDTO $workout) => [
            'id' => $workout->id,
            'name' => $workout->name,
        ], $this->workouts);
    }
}
