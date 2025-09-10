<?php

declare(strict_types=1);

namespace App\Modules\ExerciseCatalog\Application\Commands;

final readonly class UpdateExerciseCatalogCommand
{
    public function __construct(
        public int    $id,
        public string $name,
        public int    $workoutCategoryId,
        public int    $userId,
    ) {
    }
}
