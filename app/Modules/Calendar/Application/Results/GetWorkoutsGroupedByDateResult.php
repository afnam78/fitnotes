<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\Results;

use App\Modules\Calendar\Application\DTOs\EventDTO;

final class GetWorkoutsGroupedByDateResult
{
    public function __construct(public array $events)
    {
    }

    public function toArray(): array
    {
        return array_map(fn (EventDTO $event) => [
            'id' => $event->id,
            'title' => $event->title,
            'start' => $event->start,
        ], $this->events);
    }
}
