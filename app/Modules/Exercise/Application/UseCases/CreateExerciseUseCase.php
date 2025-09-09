<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Application\UseCases;

use App\Modules\Exercise\Application\Commands\CreateExerciseCommand;
use App\Modules\Exercise\Domain\Contracts\ExerciseRepositoryInterface;
use App\Modules\Exercise\Domain\Entities\Exercise;
use App\Modules\Workout\Domain\Contracts\WorkoutRepositoryInterface;
use InvalidArgumentException;

final readonly class CreateExerciseUseCase
{
    public function __construct(
        private ExerciseRepositoryInterface $repository,
        private WorkoutRepositoryInterface $workoutRepository,
    ) {

    }

    public function handle(CreateExerciseCommand $command): void
    {
        $workout = $this->workoutRepository->findByIdAndUserId($command->workoutId, $command->userId);

        if ( ! $workout) {
            throw new InvalidArgumentException('Workout not found');
        }

        $exercise = $this->getEntity($command);

        $this->repository->create($exercise);
    }

    private function getEntity(CreateExerciseCommand $command): Exercise
    {
        return new Exercise(
            id: 0,
            name: $command->name,
            workoutId: $command->workoutId,
            description: $command->description,
        );
    }
}
