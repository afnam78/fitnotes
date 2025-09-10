<?php

declare(strict_types=1);

namespace App\Modules\WorkoutCategory\Application\UseCases;

use App\Modules\WorkoutCategory\Application\Commands\UpdateWorkoutCategoryCommand;
use App\Modules\WorkoutCategory\Domain\Contracts\WorkoutCategoryRepositoryInterface;
use Exception;

final readonly class UpdateWorkoutCategoryUseCase
{
    public function __construct(private WorkoutCategoryRepositoryInterface $repository)
    {
    }

    public function handle(UpdateWorkoutCategoryCommand $command): void
    {
        $workout = $this->repository->findByIdAndUserId($command->workoutId, $command->userId);

        if ( ! $workout) {
            throw new Exception("WorkoutCategory not found");
        }

        $userWorkouts = $this->repository->getWorkoutsByUserId($command->userId);

        $workout->setName($command->name);

        $userWorkouts->validateIsUnique($workout);

        $this->repository->update($workout);
    }
}
