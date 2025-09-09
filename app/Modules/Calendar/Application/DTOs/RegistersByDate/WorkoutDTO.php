<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\DTOs\RegistersByDate;

use App\Modules\Calendar\Domain\ValueObjects\Workout;

final class WorkoutDTO
{
    public function __construct(
        public string $name,
        public array $exercises,
    ) {
    }

    public static function toDTO(Workout $workout): WorkoutDTO
    {
        $exercises = array_map(fn ($exercise) => ExerciseDTO::toDTO($exercise), $workout->exercises());

        return new WorkoutDTO(
            name: $workout->name(),
            exercises: $exercises,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'exercises' => array_map(fn (ExerciseDTO $exercise) => $exercise->toArray(), $this->exercises),
        ];
    }
}
