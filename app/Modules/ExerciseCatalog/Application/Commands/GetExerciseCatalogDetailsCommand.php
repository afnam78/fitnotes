<?php

declare(strict_types=1);

namespace App\Modules\ExerciseCatalog\Application\Commands;

final readonly class GetExerciseCatalogDetailsCommand
{
    public function __construct(
        public int $exerciseId,
        public int $userId,
    ) {
    }
}
