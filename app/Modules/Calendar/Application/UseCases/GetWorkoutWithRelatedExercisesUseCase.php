<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\UseCases;

use App\Modules\Calendar\Application\Commands\GetWorkoutWithRelatedExercisesCommand;
use App\Modules\Calendar\Application\DTOs\WorkoutWithRelatedExercises\ExerciseDTO;
use App\Modules\Calendar\Application\Results\GetWorkoutWithRelatedExercisesResult;
use App\Modules\Calendar\Domain\Contracts\WorkoutRepositoryInterface;
use App\Modules\Exercise\Domain\Entities\Exercise;

final class GetWorkoutWithRelatedExercisesUseCase
{
    public function __construct(private readonly WorkoutRepositoryInterface $workoutRepository)
    {
    }

    public function handle(GetWorkoutWithRelatedExercisesCommand $command): GetWorkoutWithRelatedExercisesResult
    {
        $workoutAndExercises = $this->workoutRepository
            ->getWorkoutWithRelatedExercises(
                workoutId: $command->workoutId,
                userId: $command->userId,
            );

        $workout = $workoutAndExercises['workout'];
        $exercises = $workoutAndExercises['exercises'];

        return new GetWorkoutWithRelatedExercisesResult(
            workoutId: $command->workoutId,
            workoutName: $workout->name(),
            exercises: array_map(fn (Exercise $exercise) => ExerciseDTO::toDTO($exercise), $exercises),
        );
    }
}
