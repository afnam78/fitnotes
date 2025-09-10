<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Domain\Entities;

use Illuminate\Support\Collection;

final class Exercise
{
    public function __construct(
        private int $id,
        private int $workoutId,
        private int $exerciseCatalogId,
        private int $order,
        private Collection $sets = new Collection(),
    ) {
    }
}
