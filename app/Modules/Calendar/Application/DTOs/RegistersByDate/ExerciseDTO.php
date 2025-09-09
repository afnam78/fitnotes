<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\DTOs\RegistersByDate;

use App\Modules\Calendar\Domain\ValueObjects\Exercise;
use App\Modules\Calendar\Domain\ValueObjects\Set;

final class ExerciseDTO
{
    public function __construct(
        public string $name,
        public array $sets,
    ) {
    }

    public static function toDTO(Exercise $exercise): ExerciseDTO
    {
        return new ExerciseDTO(
            name: $exercise->name(),
            sets: array_map(fn (Set $set) => SetDTO::toDTO($set), $exercise->sets())
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'sets' => array_map(fn (SetDTO $set) => $set->toArray(), $this->sets),
        ];
    }
}
