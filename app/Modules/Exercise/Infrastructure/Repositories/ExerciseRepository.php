<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Infrastructure\Repositories;

use App\Modules\Exercise\Domain\Aggregates\ExerciseList;
use App\Modules\Exercise\Domain\Contracts\ExerciseRepositoryInterface;
use App\Modules\Exercise\Domain\Entities\Exercise;
use App\Modules\Shared\Domain\Helpers\LogHelper;
use Exception;
use Illuminate\Support\Facades\Log;

final class ExerciseRepository implements ExerciseRepositoryInterface
{
    public function create(Exercise $exercise): void
    {
        try {
            \App\Modules\Exercise\Infrastructure\Database\Models\Exercise::create([
                'name' => $exercise->name(),
                'description' => $exercise->description(),
                'workout_id' => $exercise->workoutId(),
            ]);
        } catch (Exception $e) {
            Log::error('Error creating workout', LogHelper::body(
                exception: $e,
                class: self::class,
                method: __METHOD__,
                data: [
                    'exercise' => $exercise,
                ],
            ));
            throw $e;
        }
    }

    public function update(Exercise $exercise): void
    {
        try {
            $exerciseModel = \App\Modules\Exercise\Infrastructure\Database\Models\Exercise::where('id', $exercise->id())
                ->firstOrFail();

            $exerciseModel->name = $exercise->name();
            $exerciseModel->description = $exercise->description();
            $exerciseModel->workout_id = $exercise->workoutId();
            $exerciseModel->save();
        } catch (Exception $e) {
            Log::error('Error updating workout', LogHelper::body(
                exception: $e,
                class: self::class,
                method: __METHOD__,
                data: [
                    'exercise' => $exercise,
                ],
            ));
            throw $e;
        }
    }

    public function findByName(string $name): ?Exercise
    {
        $exercise = \App\Modules\Exercise\Infrastructure\Database\Models\Exercise::where('name', $name)
            ->first();

        return $exercise ? new Exercise(
            id: $exercise->id,
            name: $exercise->name,
            workoutId: $exercise->workout_id,
            description: $exercise->description,
        ) : null;
    }

    public function getAllByUserId(int $userId): ExerciseList
    {
        return new ExerciseList(
            items: auth()->user()
                ->exercises
                ->map(fn (\App\Modules\Exercise\Infrastructure\Database\Models\Exercise $exercise) => new Exercise(
                    id: $exercise->id,
                    name: $exercise->name,
                    workoutId: $exercise->workout_id,
                    description: $exercise->description,
                ))
        );
    }

    public function findByIdAndUserId(int $exerciseId, int $userId): ?Exercise
    {
        try {
            $exerciseModel = \App\Modules\Exercise\Infrastructure\Database\Models\Exercise::with('workout')
                ->where('id', $exerciseId)
                ->whereHas('workout', function ($query) use ($userId): void {
                    $query->where('user_id', $userId);
                })
                ->first();

            if ( ! $exerciseModel) {
                return null;
            }

            return new Exercise(
                id: $exerciseModel->id,
                name: $exerciseModel->name,
                workoutId: $exerciseModel->workout_id,
                description: $exerciseModel->description,
            );
        } catch (Exception $e) {
            Log::error('Error finding exercise by id and user id', LogHelper::body(
                exception: $e,
                class: self::class,
                method: __METHOD__,
                data: [
                    'exerciseId' => $exerciseId,
                    'userId' => $userId,
                ],
            ));
            throw $e;
        }
    }

    public function getAllByWorkoutId(int $workoutId, int $userId): array
    {
        try {
            $exerciseModels = \App\Modules\Exercise\Infrastructure\Database\Models\Exercise::with('workout')
                ->whereHas('workout', function ($query) use ($userId): void {
                    $query->where('user_id', $userId);
                })
                ->where('workout_id', $workoutId)
                ->get();

            return $exerciseModels->map(fn ($exerciseModel) => new Exercise(
                id: $exerciseModel->id,
                name: $exerciseModel->name,
                workoutId: $exerciseModel->workout_id,
                description: $exerciseModel->description,
            ))->toArray();

        } catch (Exception $e) {
            Log::error('Error getting exercises by workout id', LogHelper::body(
                exception: $e,
                class: self::class,
                method: __METHOD__,
                data: [
                    'workoutId' => $workoutId,
                ],
            ));
            throw $e;
        }
    }

    public function delete(Exercise $exercise): void
    {
        try {
            $exerciseModel = \App\Modules\Exercise\Infrastructure\Database\Models\Exercise::where('id', $exercise->id())
                ->firstOrFail();

            $exerciseModel->delete();
        } catch (Exception $e) {
            Log::error('Error deleting exercise', LogHelper::body(
                exception: $e,
                class: self::class,
                method: __METHOD__,
                data: [
                    'exercise' => $exercise,
                ],
            ));
            throw $e;
        }
    }

}
