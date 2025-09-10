<?php

declare(strict_types=1);

namespace App\Modules\WorkoutCategory\Application\Results;

final readonly class GetWorkoutCategoryDetailsResult
{
    public function __construct(
        public int    $id,
        public string $name,
    ) {
    }
}
