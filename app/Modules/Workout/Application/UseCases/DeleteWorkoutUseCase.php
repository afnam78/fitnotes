<?php

namespace App\Modules\Workout\Application\UseCases;

use App\Modules\Workout\Application\Commands\DeleteWorkoutCommand;
use App\Modules\Workout\Domain\Contracts\WorkoutRepositoryInterface;

readonly class DeleteWorkoutUseCase
{
    public function __construct(private WorkoutRepositoryInterface $repository)
    {
    }

    public function handle(DeleteWorkoutCommand $command): void
    {
        $workout = $this->repository->findByIdAndUserId($command->workoutId, $command->userId);

        if ( ! $workout)
        {
            throw new \InvalidArgumentException('Workout not found.');
        }

        $this->repository->delete($command->workoutId);
    }
}
