<?php

declare(strict_types=1);

namespace App\Modules\ExerciseCatalog\Application\UseCases;

use App\Modules\ExerciseCatalog\Application\Commands\CreateExerciseCatalogCommand;
use App\Modules\ExerciseCatalog\Domain\Contracts\ExerciseCatalogRepositoryInterface;
use App\Modules\ExerciseCatalog\Domain\Entities\ExerciseCatalog;
use App\Modules\WorkoutCategory\Domain\Contracts\WorkoutCategoryRepositoryInterface;
use InvalidArgumentException;

final readonly class CreateExerciseCatalogUseCase
{
    public function __construct(
        private ExerciseCatalogRepositoryInterface $repository,
        private WorkoutCategoryRepositoryInterface $workoutRepository,
    ) {

    }

    public function handle(CreateExerciseCatalogCommand $command): void
    {
        $workout = $this->workoutRepository->findByIdAndUserId($command->workoutId, $command->userId);

        if ( ! $workout) {
            throw new InvalidArgumentException('WorkoutCategory not found');
        }

        $exercise = $this->getEntity($command);

        $this->repository->create($exercise);
    }

    private function getEntity(CreateExerciseCatalogCommand $command): ExerciseCatalog
    {
        return new ExerciseCatalog(
            id: 0,
            name: $command->name,
            workoutCategoryId: $command->workoutId,
        );
    }
}
