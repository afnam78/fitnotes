<?php

declare(strict_types=1);

namespace App\Modules\ExerciseCatalog\Domain\Entities;

final class ExerciseCatalog
{
    public function __construct(
        private readonly int $id,
        private string       $name,
        private int          $workoutCategoryId,
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

    public function workoutCategoryId(): int
    {
        return $this->workoutCategoryId;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setWorkoutCategoryId(int $workoutCategoryId): void
    {
        $this->workoutCategoryId = $workoutCategoryId;
    }
}
