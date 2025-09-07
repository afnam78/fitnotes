<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\Commands;

final readonly class GetEventsCommand
{
    public function __construct(
        public int $userId,
    ) {
    }
}
