<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Infrastructure\Repositories;

use App\Modules\Calendar\Domain\Contracts\WorkoutRepositoryInterface;
use App\Modules\Calendar\Domain\ValueObjects\Exercise;
use App\Modules\Calendar\Domain\ValueObjects\Workout;
use App\Modules\Set\Infrastructure\Database\Models\Set;
use App\Modules\Shared\Domain\Helpers\LogHelper;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class WorkoutRepository implements WorkoutRepositoryInterface
{
    public function getRegistersByDate(int $userId, Carbon $date): array
    {
        try {
            $result = Set::with('exercise.workout')
                ->where('set_date', $date->format('Y-m-d'))->whereHas('exercise.workout', function ($query) use ($userId): void {
                    $query->where('user_id', $userId);
                })
                ->get()
                ->groupBy('exercise.workout.name')
                ->map(fn ($setsByWorkout) => $setsByWorkout->groupBy('exercise.name'));

            return $result
                ->map(function (Collection $workout, string $workoutName) {
                    $exercises = $workout->map(function (Collection $exercise, string $exerciseName) {
                        $sets = $exercise->map(fn (Set $set) => new \App\Modules\Calendar\Domain\ValueObjects\Set(id: $set['id'], exerciseId: $set['exercise_id'], workoutId: $set['exercise']['workout_id'], reps: $set['reps'], weight: (float)$set['weight'], ));
                        return new Exercise(name: $exerciseName, sets: $sets->toArray());
                    });
                    return new Workout(name: $workoutName, exercises: $exercises->toArray());
                })
                ->values()
                ->toArray();

        } catch (Exception $e) {
            Log::error($e->getMessage(), LogHelper::body(exception: $e, class: __CLASS__, method: __METHOD__, data: ['userId' => $userId, 'date' => $date->format('Y-m-d'),]));
            throw $e;
        }
    }

    public function getWorkoutWithRelatedExercises(int $workoutId, int $userId): array
    {
        try {
            $rows = DB::table('workouts')
                ->leftJoin('exercises', 'exercises.workout_id', '=', 'workouts.id')
                ->where('workouts.id', $workoutId)
                ->where('workouts.user_id', $userId)
                ->select(
                    'workouts.id as workout_id',
                    'workouts.name as workout_name',
                    'workouts.description as workout_description',
                    'workouts.user_id',
                    'exercises.id as exercise_id',
                    'exercises.name as exercise_name',
                    'exercises.description as exercise_description'
                )
                ->get();

            if ($rows->isEmpty()) {
                throw new \Illuminate\Database\Eloquent\ModelNotFoundException("Workout not found");
            }

            // Workout (primer registro basta, ya que es el mismo para todas las filas)
            $first = $rows->first();
            $workout = new \App\Modules\Workout\Domain\Entities\Workout(
                id: $first->workout_id,
                name: $first->workout_name,
                userId: $first->user_id,
                description: $first->workout_description,
            );

            // Exercises (si existen)
            $exercises = $rows
                ->filter(fn ($row) => $row->exercise_id !== null) // evitar null si no hay ejercicios
                ->map(fn ($row) => new \App\Modules\Exercise\Domain\Entities\Exercise(
                    id: $row->exercise_id,
                    name: $row->exercise_name,
                    workoutId: $row->workout_id,
                    description: $row->exercise_description,
                ))
                ->values()
                ->toArray();

            return [
                'workout' => $workout,
                'exercises' => $exercises,
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
