<?php

namespace App\Modules\Workout\Domain\Aggregates;

use App\Modules\Workout\Domain\Entities\Workout;

readonly class WorkoutList
{
    public function __construct(private array $items)
    {

    }

    public function validateIsUnique(Workout $workout): void
    {
        $uniqueNames = collect($this->items)->filter(function (Workout $workout) use ($id, $name) {
            return $workout->id() !== $id && $workout->name() === $name;
        });

        if ($uniqueNames->isNotEmpty()) {
            throw new \Exception("Workout name must be unique");
        }
    }
}
