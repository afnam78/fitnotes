<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Domain\Entities;

use Illuminate\Support\Carbon;

final class Event
{
    public function __construct(
        private readonly Carbon $start,
        private readonly string $title,
        private readonly int $id,
    ) {
    }

    public function start(): Carbon
    {
        return $this->start;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function id(): int
    {
        return $this->id;
    }
}
