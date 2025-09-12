<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Infrastructure\Repositories;

use App\Modules\Calendar\Domain\Contracts\WorkoutRepositoryInterface;
use App\Modules\Calendar\Domain\ValueObjects\Exercise;
use App\Modules\Calendar\Domain\ValueObjects\Workout;
use App\Modules\Shared\Domain\Helpers\LogHelper;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class WorkoutRepository implements WorkoutRepositoryInterface
{
    public function getRegistersByDate(int $userId, Carbon $date): array
    {
        try {
            $workouts = DB::table('workouts')
                ->join('exercises', 'exercises.workout_id', '=', 'workouts.id')
                ->join('sets', 'sets.exercise_id', '=', 'exercises.id')
                ->whereDate('sets.set_date', $date->format('Y-m-d'))
                ->where('workouts.user_id', $userId)
                ->selectRaw('
                workouts.name as workout_name,
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        "exercise_name", exercises.name,
                        "sets", (
                            SELECT JSON_ARRAYAGG(
                                JSON_OBJECT(
                                    "id", s.id,
                                    "exercise_id", s.exercise_id,
                                    "workout_id", exercises.workout_id,
                                    "reps", s.reps,
                                    "weight", s.weight
                                )
                            )
                            FROM sets s
                            WHERE s.exercise_id = exercises.id
                              AND DATE(s.set_date) = ?
                        )
                    )
                ) as exercises
            ', [$date->format('Y-m-d')])
                ->groupBy('workouts.id', 'workouts.name')
                ->get();

            return $workouts->map(function ($row) {
                $exercises = collect(json_decode($row->exercises, true))
                    ->map(fn ($exercise) => new Exercise(
                        name: $exercise['exercise_name'],
                        sets: collect($exercise['sets'])->map(fn ($set) => new \App\Modules\Calendar\Domain\ValueObjects\Set(
                            id: $set['id'],
                            exerciseId: $set['exercise_id'],
                            workoutId: $set['workout_id'],
                            reps: $set['reps'],
                            weight: (float) $set['weight'],
                        ))->toArray()
                    ));

                return new Workout(
                    name: $row->workout_name,
                    exercises: $exercises->toArray()
                );
            })->toArray();

        } catch (Exception $e) {
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
