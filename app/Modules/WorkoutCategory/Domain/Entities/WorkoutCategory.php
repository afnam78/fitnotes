<?php

declare(strict_types=1);

namespace App\Modules\WorkoutCategory\Domain\Entities;

final class WorkoutCategory
{
    private int $id;
    private string $name;
    private int $userId;

    public function __construct(
        int $id,
        string $name,
        int $userId,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->userId = $userId;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function setName(string $value): void
    {
        $this->name = $value;
    }
}
