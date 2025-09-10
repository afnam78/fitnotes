<?php

declare(strict_types=1);

namespace App\Modules\WorkoutCategory\Domain\Aggregates;

use App\Modules\WorkoutCategory\Domain\Entities\WorkoutCategory;
use App\Modules\WorkoutCategory\Domain\Exceptions\WorkoutCategoryMustBeUnique;
use Illuminate\Support\Collection;

final readonly class WorkoutCategoryList
{
    public function __construct(private array $items)
    {

    }

    public function validateIsUnique(WorkoutCategory $workoutCategory): void
    {
        $uniqueNames = collect($this->items)->filter(fn (WorkoutCategory $item) => $workoutCategory->id() !== $item->id() && $workoutCategory->name() === $item->name() && $workoutCategory->userId() === $item->userId());

        if ($uniqueNames->isNotEmpty()) {
            throw new WorkoutCategoryMustBeUnique();
        }
    }

    public function items(): Collection
    {
        return collect($this->items);
    }
}
