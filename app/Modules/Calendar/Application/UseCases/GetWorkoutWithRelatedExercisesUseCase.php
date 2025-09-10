<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Application\UseCases;

use App\Modules\Calendar\Application\Commands\GetWorkoutWithRelatedExercisesCommand;
use App\Modules\Calendar\Application\DTOs\WorkoutWithRelatedExercises\ExerciseDTO;
use App\Modules\Calendar\Application\Results\GetWorkoutWithRelatedExercisesResult;
use App\Modules\Calendar\Domain\Contracts\WorkoutCategoryRepositoryInterface;
use App\Modules\ExerciseCatalog\Domain\Entities\ExerciseCatalog;

final readonly class GetWorkoutWithRelatedExercisesUseCase
{
    public function __construct(private WorkoutCategoryRepositoryInterface $workoutRepository)
    {
    }

    public function handle(GetWorkoutWithRelatedExercisesCommand $command): GetWorkoutWithRelatedExercisesResult
    {
        $workoutAndExercises = $this->workoutRepository
            ->getWorkoutWithRelatedExercises(
                workoutId: $command->workoutId,
                userId: $command->userId,
            );

        $workout = $workoutAndExercises['workout_category'];
        $exercises = $workoutAndExercises['exercise_catalogs'];

        return new GetWorkoutWithRelatedExercisesResult(
            workoutId: $command->workoutId,
            workoutName: $workout->name(),
            exercises: array_map(fn (ExerciseCatalog $exercise) => ExerciseDTO::toDTO($exercise), $exercises),
        );
    }
}
