<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Infrastructure\Repositories;

use App\Modules\Calendar\Domain\Contracts\WorkoutCategoryRepositoryInterface;
use App\Modules\Calendar\Domain\ValueObjects\Exercise;
use App\Modules\Calendar\Domain\ValueObjects\Workout;
use App\Modules\Set\Infrastructure\Database\Models\Set;
use App\Modules\Shared\Domain\Helpers\LogHelper;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

final class WorkoutCategoryRepository implements WorkoutCategoryRepositoryInterface
{
    public function getRegistersByDate(int $userId, Carbon $date): array
    {
        try {
            $result = Set::query()
                ->with('exercise.workout', 'exercise.exerciseCatalog.workoutCategory')
                ->whereHas('exercise.workout', function ($query) use ($userId, $date): void {
                    $query->where('user_id', $userId)
                        ->where('date', $date->format('Y-m-d'));
                })
                ->get()
                ->groupBy('exercise.exerciseCatalog.workoutCategory.name')
                ->map(fn ($setsByWorkout) => $setsByWorkout->groupBy('exercise.exerciseCatalog.name'));

            return $result
                ->map(function (Collection $workout, string $workoutName) {
                    $exercises = $workout
                        ->map(function (Collection $exercise, string $exerciseName) {
                            $sets = $exercise
                                ->map(fn (Set $set) => new \App\Modules\Calendar\Domain\ValueObjects\Set(
                                    id: $set['id'],
                                    exerciseId: $set['exercise_id'],
                                    workoutId: $set['exercise']['workout_id'],
                                    reps: $set['reps'],
                                    weight: (float) $set['weight'],
                                    order: $set['order'],
                                ));

                            return new Exercise(
                                name: $exerciseName,
                                sets: $sets->toArray()
                            );
                        });

                    return new Workout(
                        name: $workoutName,
                        exercises: $exercises->toArray()
                    );
                })
                ->values()
                ->toArray();

        } catch (Exception $e) {
            dd($e->getMessage());
            Log::error($e->getMessage(), LogHelper::body(
                exception: $e,
                class: __CLASS__,
                method: __METHOD__,
                data: [
                    'userId' => $userId,
                    'date' => $date->format('Y-m-d'),
                ]
            ));

            throw $e;
        }
    }

    public function getWorkoutWithRelatedExercises(int $workoutId, int $userId): array
    {

        try {
            $workout = \App\Modules\WorkoutCategory\Infrastructure\Database\Models\WorkoutCategory::where('id', $workoutId)
                ->where('user_id', $userId)
                ->firstOrFail();

            return [
                'workout_category' => new \App\Modules\WorkoutCategory\Domain\Entities\WorkoutCategory(
                    id: $workout->id,
                    name: $workout->name,
                    userId: $workout->user_id,
                ),

                'exercise_catalogs' => $workout->exerciseCatalogs->map(fn ($exercise) => new \App\Modules\ExerciseCatalog\Domain\Entities\ExerciseCatalog(
                    id: $exercise->id,
                    name: $exercise->name,
                    workoutCategoryId: $workoutId,
                ))->toArray(),
            ];

        } catch (Exception $e) {
            Log::error($e->getMessage(), LogHelper::body(
                exception: $e,
                class: __CLASS__,
                method: __METHOD__,
                data: [
                    'workoutId' => $workoutId,
                    'userId' => $userId,
                ]
            ));
            throw $e;
        }

    }
}
