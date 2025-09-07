<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Application\UseCases;

use App\Modules\Exercise\Application\Commands\UpdateExerciseCommand;
use App\Modules\Exercise\Domain\Contracts\ExerciseRepositoryInterface;
use Exception;

final readonly class UpdateExerciseUseCase
{
    public function __construct(private ExerciseRepositoryInterface $repository)
    {
    }

    public function handle(UpdateExerciseCommand $command): void
    {
        $exercise = $this->repository->findByIdAndUserId($command->id, $command->userId);

        if (null === $exercise) {
            throw new Exception("Exercise not found");
        }

        $exercise->setName($command->name);
        $exercise->setDescription($command->description);
        $exercise->setWorkoutId($command->workoutId);

        $this->repository->update($exercise);
    }
}
