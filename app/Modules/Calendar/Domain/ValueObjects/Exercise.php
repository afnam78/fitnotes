<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Domain\ValueObjects;

final class Exercise
{
    public function __construct(
        private string $name,
        private array $sets
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function sets(): array
    {
        return $this->sets;
    }
}
