<?php

declare(strict_types=1);

namespace App\Modules\Workout\Domain\Entities;

final class Workout
{
    private int $id;
    private string $name;
    private int $userId;
    private ?string $description;

    public function __construct(
        int $id,
        string $name,
        int $userId,
        ?string $description,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->userId = $userId;
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

    public function userId(): int
    {
        return $this->userId;
    }

    public function description(): ?string
    {
        return $this->description;
    }
}
