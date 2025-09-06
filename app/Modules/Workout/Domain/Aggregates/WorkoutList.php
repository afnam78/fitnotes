<?php

declare(strict_types=1);

namespace App\Modules\Workout\Domain\Aggregates;

use App\Modules\Workout\Domain\Entities\Workout;
use Exception;

final readonly class WorkoutList
{
    public function __construct(private array $items)
    {

    }

    public function validateIsUnique(Workout $workout): void
    {
        $uniqueNames = collect($this->items)->filter(fn (Workout $workout) => $workout->id() !== $id && $workout->name() === $name);

        if ($uniqueNames->isNotEmpty()) {
            throw new Exception("Workout name must be unique");
        }
    }
}
