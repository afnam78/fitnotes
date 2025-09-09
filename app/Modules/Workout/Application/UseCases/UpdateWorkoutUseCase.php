<?php

declare(strict_types=1);

namespace App\Modules\Workout\Application\UseCases;

use App\Modules\Workout\Application\Commands\UpdateWorkoutCommand;
use App\Modules\Workout\Domain\Contracts\WorkoutRepositoryInterface;
use Exception;

final readonly class UpdateWorkoutUseCase
{
    public function __construct(private WorkoutRepositoryInterface $repository)
    {
    }

    public function handle(UpdateWorkoutCommand $command): void
    {
        $workout = $this->repository->findByIdAndUserId($command->workoutId, $command->userId);

        if ( ! $workout) {
            throw new Exception("Workout not found");
        }

        $userWorkouts = $this->repository->getWorkoutsByUserId($command->userId);

        $workout->setName($command->name);
        $workout->setDescription($command->description);

        $userWorkouts->validateIsUnique($workout);

        $this->repository->update($workout);
    }
}
