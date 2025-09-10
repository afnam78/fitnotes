<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\DTOs\WorkoutWithRelatedExercises;

use App\Modules\ExerciseCatalog\Domain\Entities\ExerciseCatalog;

final class ExerciseDTO
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }

    public static function toDTO(ExerciseCatalog $exercise): ExerciseDTO
    {
        return new ExerciseDTO(
            id: $exercise->id(),
            name: $exercise->name(),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
