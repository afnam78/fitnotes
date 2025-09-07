<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Domain\Entities;

final class Exercise
{
    public function __construct(
        private readonly int $id,
        private string       $name,
        private int $workoutId,
        private ?string      $description = null,
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

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setWorkoutId(int $workoutId): void
    {
        $this->workoutId = $workoutId;
    }
}
