<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\DTOs\RegistersByDate;

final class SelectedExerciseDTO
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
