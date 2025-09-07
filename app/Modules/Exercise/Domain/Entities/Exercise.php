<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Domain\Entities;

final readonly class Exercise
{
    public function __construct(
        private int $id,
        private string $name,
        private int $workoutId,
        private ?string $description = null,
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function workoutId(): int
    {
        return $this->workoutId;
    }

    public function description(): ?string
    {
        return $this->description;
    }
}
