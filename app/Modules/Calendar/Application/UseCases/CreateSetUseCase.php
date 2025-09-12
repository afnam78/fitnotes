<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\UseCases;

use App\Modules\Calendar\Application\Commands\CreateSetCommand;
use App\Modules\Exercise\Domain\Contracts\ExerciseRepositoryInterface;
use App\Modules\Set\Domain\Contracts\SetRepositoryInterface;
use App\Modules\Set\Domain\Entities\Set;
use InvalidArgumentException;

final readonly class CreateSetUseCase
{
    public function __construct(
        private ExerciseRepositoryInterface $exerciseRepository,
        private SetRepositoryInterface      $setRepository
    ) {
    }

    public function handle(CreateSetCommand $command): void
    {
        $exercise = $this->exerciseRepository->findByIdAndUserId($command->exerciseId, $command->userId);

        if (null === $exercise) {
            throw new InvalidArgumentException('Exercise not found');
        }

        $set = $this->getEntity($command);

        $this->setRepository->create($set);
    }

    private function getEntity(CreateSetCommand $command): Set
    {
        return new Set(
            id: 0,
            exerciseId: $command->exerciseId,
            reps: $command->reps,
            weight: $command->weight,
            date: $command->date,
        );
    }
}
