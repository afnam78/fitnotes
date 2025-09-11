<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Domain\Entities;

final class Exercise
{
    private readonly int $id;
    private string $name;
    private int $workoutId;
    private ?string $description = null;

    public function __construct(
        int     $id,
        string  $name,
        int     $workoutId,
        ?string $description = null,
    ) {
        $this->id = $id;
        $this->setName($name);
        $this->workoutId = $workoutId;
        $this->description = $description;
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
        $this->name = str($name)
            ->trim()
            ->ascii()
            ->ucfirst()
            ->toString();
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
