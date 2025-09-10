<?php

declare(strict_types=1);

namespace App\Modules\ExerciseCatalog\Application\Commands;

final readonly class CreateExerciseCatalogCommand
{
    public function __construct(
        public string $name,
        public int $workoutId,
        public int $userId,
        public ?string $description = null,
    ) {

    }
}
