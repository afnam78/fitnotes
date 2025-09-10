<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\UseCases;

use App\Modules\Calendar\Application\Commands\CreateSetCommand;
use App\Modules\ExerciseCatalog\Domain\Contracts\ExerciseCatalogRepositoryInterface;
use App\Modules\Set\Domain\Contracts\SetRepositoryInterface;
use App\Modules\Set\Domain\Entities\Set;
use InvalidArgumentException;

final readonly class CreateSetUseCase
{
    public function __construct(
        private ExerciseCatalogRepositoryInterface $exerciseCatalogRepository,
        private SetRepositoryInterface             $setRepository
    ) {
    }

    public function handle(CreateSetCommand $command): void
    {
        $exerciseCatalog = $this->exerciseCatalogRepository->findByIdAndUserId($command->exerciseCatalogId, $command->userId);

        if (null === $exerciseCatalog) {
            throw new InvalidArgumentException('Exercise not found');
        }

        $this->setRepository->add(
            userId: $command->userId,
            set: new Set(
                id: 0,
                exerciseCatalogId: $command->exerciseCatalogId,
                reps: $command->reps,
                weight: $command->weight,
                order: 0
            ),
            date: $command->date,
        );
    }
}
