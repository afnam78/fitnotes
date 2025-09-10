<?php

declare(strict_types=1);

namespace App\Modules\ExerciseCatalog\Application\Commands;

final readonly class DeleteExerciseCatalogCommand
{
    public function __construct(
        public int $id,
        public int $userId,
    ) {
    }
}
