<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Domain\ValueObjects;

final readonly class Workout
{
    public function __construct(
        private string $name,
        private array  $exercises,
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function exercises(): array
    {
        return $this->exercises;
    }
}
