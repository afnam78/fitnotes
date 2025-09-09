<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Application\UseCases;

use App\Modules\Exercise\Application\Commands\DeleteExerciseCommand;
use App\Modules\Exercise\Domain\Contracts\ExerciseRepositoryInterface;
use Exception;

final readonly class DeleteExerciseUseCase
{
    public function __construct(private ExerciseRepositoryInterface $repository)
    {
    }

    public function handle(DeleteExerciseCommand $command): void
    {
        $exercise = $this->repository->findByIdAndUserId($command->id, $command->userId);

        if ( ! $exercise) {
            throw new Exception('Exercise not found');
        }

        $this->repository->delete($exercise);
    }
}
