<?php

declare(strict_types=1);

namespace App\Modules\Workout\Domain\Aggregates;

use App\Modules\Workout\Domain\Entities\Workout;
use Exception;
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
            throw new Exception("Workout name must be unique");
        }
    }

    public function items(): Collection
    {
        return collect($this->items);
    }
}
