<?php

declare(strict_types=1);

namespace App\Modules\ExerciseCatalog\Application\Results;

final class GetExerciseCatalogDetailsResult
{
    public function __construct(
        public int     $id,
        public string  $name,
        public int     $workoutCategoryId,
    ) {
    }
}
