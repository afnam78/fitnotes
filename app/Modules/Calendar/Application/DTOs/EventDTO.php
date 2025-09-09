<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\DTOs;

final class EventDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public string $start,
    ) {
    }
}
