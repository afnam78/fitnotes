<?php

declare(strict_types=1);

namespace App\Modules\ExerciseCatalog\Application\UseCases;

use App\Modules\ExerciseCatalog\Application\Commands\UpdateExerciseCatalogCommand;
use App\Modules\ExerciseCatalog\Domain\Contracts\ExerciseCatalogRepositoryInterface;
use Exception;

final readonly class UpdateExerciseCatalogUseCase
{
    public function __construct(private ExerciseCatalogRepositoryInterface $repository)
    {
    }

    public function handle(UpdateExerciseCatalogCommand $command): void
    {
        $exercise = $this->repository->findByIdAndUserId($command->id, $command->userId);

        if (null === $exercise) {
            throw new Exception("Exercise not found");
        }

        $exercise->setName($command->name);
        $exercise->setWorkoutCategoryId($command->workoutCategoryId);

        $this->repository->update($exercise);
    }
}
