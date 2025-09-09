<?php

declare(strict_types=1);

namespace App\Modules\Workout\Infrastructure\Repositories;

use App\Modules\Shared\Domain\Helpers\LogHelper;
use App\Modules\Workout\Domain\Aggregates\WorkoutList;
use App\Modules\Workout\Domain\Contracts\WorkoutRepositoryInterface;
use App\Modules\Workout\Domain\Entities\Workout;
use Exception;
use Illuminate\Support\Facades\Log;

final class WorkoutRepository implements WorkoutRepositoryInterface
{
    public function create(Workout $workout): void
    {
        try {
            \App\Modules\Workout\Infrastructure\Database\Models\Workout::create([
                'name' => $workout->name(),
                'user_id' => $workout->userId(),
                'description' => $workout->description(),
            ]);

        } catch (Exception $exception) {
            Log::error(
                $exception->getMessage(),
                LogHelper::body($exception, __CLASS__, __METHOD__, ['workout' => $workout]),
            );

            throw $exception;
        }
    }

    public function findByIdAndUserId(int $workoutId, int $userId): ?Workout
    {
        $workoutModel = \App\Modules\Workout\Infrastructure\Database\Models\Workout::where('id', $workoutId)
            ->where('user_id', $userId)
            ->first();

        return $workoutModel ? new Workout(
            id: $workoutModel->id,
            name: $workoutModel->name,
            userId: $workoutModel->user_id,
            description: $workoutModel->description,
        ) : null;
    }

    public function update(Workout $workout): void
    {
        try {
            $workoutModel = \App\Modules\Workout\Infrastructure\Database\Models\Workout::where('id', $workout->id())
                ->where('user_id', $workout->userId())
                ->firstOrFail();

            if ($workoutModel) {
                $workoutModel->name = $workout->name();
                $workoutModel->description = $workout->description();
                $workoutModel->save();
            }

        } catch (Exception $exception) {
            Log::error(
                $exception->getMessage(),
                LogHelper::body($exception, __CLASS__, __METHOD__, ['workout' => $workout]),
            );
            throw $exception;

        }
    }

    public function delete(int $id): void
    {
        try {
            $workout = \App\Modules\Workout\Infrastructure\Database\Models\Workout::findOrFail($id);

            $workout->delete();
        } catch (Exception $e) {
            Log::error('Error deleting workout', [
                'error' => $e->getMessage(),
                'data' => $id,
            ]);
            throw $e;
        }
    }


    public function getWorkoutsByUserId(int $userId): WorkoutList
    {
        $workoutModels = \App\Modules\Workout\Infrastructure\Database\Models\Workout::where('user_id', $userId)->get();

        $items = $workoutModels->map(fn ($workoutModel) => new Workout(
            id: $workoutModel->id,
            name: $workoutModel->name,
            userId: $workoutModel->user_id,
            description: $workoutModel->description,
        ))->toArray();

        return new WorkoutList($items);
    }
}
