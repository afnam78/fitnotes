<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\UseCases;

use App\Modules\Calendar\Application\Commands\GetEventsCommand;
use App\Modules\Calendar\Application\DTOs\EventDTO;
use App\Modules\Calendar\Application\Results\GetWorkoutsGroupedByDateResult;
use App\Modules\Calendar\Domain\Contracts\EventRepositoryInterface;
use App\Modules\Calendar\Domain\Entities\Event;

final readonly class GetEventsUseCase
{
    public function __construct(private EventRepositoryInterface $repository)
    {
    }

    public function handle(GetEventsCommand $command): GetWorkoutsGroupedByDateResult
    {
        $events = $this->repository->getWorkoutEvents($command->userId);

        return new GetWorkoutsGroupedByDateResult(array_map(
            fn (Event $event) => new EventDTO(
                $event->id(),
                $event->title(),
                $event->start()->toDateString(),
            ),
            $events
        ));
    }
}
