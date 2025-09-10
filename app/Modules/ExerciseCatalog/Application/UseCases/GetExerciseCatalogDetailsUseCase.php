<?php

declare(strict_types=1);

namespace App\Modules\ExerciseCatalog\Application\UseCases;

use App\Modules\ExerciseCatalog\Application\Commands\GetExerciseCatalogDetailsCommand;
use App\Modules\ExerciseCatalog\Application\Results\GetExerciseCatalogDetailsResult;
use App\Modules\ExerciseCatalog\Domain\Contracts\ExerciseCatalogRepositoryInterface;
use Exception;

final readonly class GetExerciseCatalogDetailsUseCase
{
    public function __construct(private ExerciseCatalogRepositoryInterface $repository)
    {
    }

    public function handle(GetExerciseCatalogDetailsCommand $command): GetExerciseCatalogDetailsResult
    {
        $exercise = $this->repository->findByIdAndUserId($command->exerciseId, $command->userId);

        if (null === $exercise) {
            return throw new Exception("Exercise not found");
        }

        return new GetExerciseCatalogDetailsResult(
            id: $exercise->id(),
            name: $exercise->name(),
            workoutCategoryId: $exercise->workoutCategoryId(),
        );
    }
}
