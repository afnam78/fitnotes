<?php

declare(strict_types=1);

namespace App\Modules\Workout\Domain\Entities;

use App\Modules\Exercise\Domain\Entities\Exercise;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

final class Workout
{
    public function __construct(
        private int $id,
        private int $userId,
        private Carbon $date,
        private Collection $exercises = new Collection(),
    ) {

    }

    public function findExerciseById(int $id): ?Exercise
    {
        return $this->exercises->first(fn ($exercise) => $exercise->id() === $id);
    }
}
