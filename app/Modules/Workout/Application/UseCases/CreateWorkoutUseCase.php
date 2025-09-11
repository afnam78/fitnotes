<?php

declare(strict_types=1);

namespace App\Modules\Workout\Application\UseCases;

use App\Modules\Workout\Application\Commands\CreateWorkoutCommand;
use App\Modules\Workout\Domain\Contracts\WorkoutRepositoryInterface;
use App\Modules\Workout\Domain\Entities\Workout;
use Exception;

final class CreateWorkoutUseCase
{
    public function __construct(private WorkoutRepositoryInterface $repository)
    {
    }

    /**
     * @throws Exception
     */
    public function handle(CreateWorkoutCommand $command): void
    {
        $workout = $this->makeEntity($command);
        $workouts = $this->repository->getWorkoutsByUserId($command->userId);

        $workouts->validateIsUnique($workout);

        $this->repository->create($workout);
    }

    private function makeEntity(CreateWorkoutCommand $command): Workout
    {
        return new Workout(
            id: 0,
            name: $command->name,
            userId: $command->userId,
            description: $command->description,
        );
    }
}
