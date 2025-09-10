<?php

declare(strict_types=1);

namespace App\Modules\ExerciseCatalog\Application\UseCases;

use App\Modules\ExerciseCatalog\Application\Commands\DeleteExerciseCatalogCommand;
use App\Modules\ExerciseCatalog\Domain\Contracts\ExerciseCatalogRepositoryInterface;
use Exception;

final readonly class DeleteExerciseCatalogUseCase
{
    public function __construct(private ExerciseCatalogRepositoryInterface $repository)
    {
    }

    public function handle(DeleteExerciseCatalogCommand $command): void
    {
        $exercise = $this->repository->findByIdAndUserId($command->id, $command->userId);

        if ( ! $exercise) {
            throw new Exception('Exercise not found');
        }

        $this->repository->delete($exercise);
    }
}
