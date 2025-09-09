<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\Results;

use App\Modules\Calendar\Application\DTOs\RegistersByDate\SelectedExerciseDTO;

final class GetExercisesByWorkoutResult
{
    public function __construct(
        public array $exercises,
    ) {
    }

    public function toArray(): array
    {
        return array_map(fn (SelectedExerciseDTO $exercise) => $exercise->toArray(), $this->exercises);
    }
}
