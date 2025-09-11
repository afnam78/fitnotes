<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Domain\Aggregates;

use App\Modules\Exercise\Domain\Entities\Exercise;
use App\Modules\Exercise\Domain\Exceptions\ExerciseAlreadyExists;
use Illuminate\Support\Collection;

final class ExerciseList
{
    public function __construct(
        public Collection $items = new Collection()
    ) {
    }

    public function validateIfUnique(Exercise $exercise): void
    {
        if ($this->items->contains(fn ($item) => $item->id() !== $exercise->id() && $item->name() === $exercise->name())) {
            throw new ExerciseAlreadyExists();
        }
    }
}
