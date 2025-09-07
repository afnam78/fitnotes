<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Application\Results;

final class GetExerciseDetailsResult
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public int $workoutId
    ) {
    }
}
