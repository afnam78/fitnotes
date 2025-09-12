<?php

declare(strict_types=1);

namespace App\Modules\Workout\Domain\Aggregates;

use App\Modules\Workout\Domain\Entities\Workout;
use App\Modules\Workout\Domain\Exceptions\WorkoutAlreadyExists;
use Illuminate\Support\Collection;

final readonly class WorkoutList
{
    public function __construct(private array $items)
    {

    }

    public function validateIsUnique(Workout $workout): void
    {
        $uniqueNames = collect($this->items)->filter(fn (Workout $item) => $workout->id() !== $item->id() && $workout->name() === $item->name());

        if ($uniqueNames->isNotEmpty()) {
            throw new WorkoutAlreadyExists();
        }
    }

    public function items(): Collection
    {
        return collect($this->items);
    }
}
