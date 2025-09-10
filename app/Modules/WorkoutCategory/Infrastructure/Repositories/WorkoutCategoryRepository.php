<?php

declare(strict_types=1);

namespace App\Modules\WorkoutCategory\Infrastructure\Repositories;

use App\Modules\Shared\Domain\Helpers\LogHelper;
use App\Modules\WorkoutCategory\Domain\Aggregates\WorkoutCategoryList;
use App\Modules\WorkoutCategory\Domain\Contracts\WorkoutCategoryRepositoryInterface;
use App\Modules\WorkoutCategory\Domain\Entities\WorkoutCategory;
use Exception;
use Illuminate\Support\Facades\Log;

final class WorkoutCategoryRepository implements WorkoutCategoryRepositoryInterface
{
    public function create(WorkoutCategory $workout): void
    {
        try {
            \App\Modules\WorkoutCategory\Infrastructure\Database\Models\WorkoutCategory::create([
                'name' => $workout->name(),
                'user_id' => $workout->userId(),
            ]);

        } catch (Exception $exception) {
            Log::error(
                $exception->getMessage(),
                LogHelper::body($exception, __CLASS__, __METHOD__, ['workout' => $workout]),
            );

            throw $exception;
        }
    }

    public function findByIdAndUserId(int $workoutId, int $userId): ?WorkoutCategory
    {
        $workoutModel = \App\Modules\WorkoutCategory\Infrastructure\Database\Models\WorkoutCategory::where('id', $workoutId)
            ->where('user_id', $userId)
            ->first();

        return $workoutModel ? new WorkoutCategory(
            id: $workoutModel->id,
            name: $workoutModel->name,
            userId: $workoutModel->user_id,
        ) : null;
    }

    public function update(WorkoutCategory $workout): void
    {
        try {
            $workoutModel = \App\Modules\WorkoutCategory\Infrastructure\Database\Models\WorkoutCategory::where('id', $workout->id())
                ->where('user_id', $workout->userId())
                ->firstOrFail();

            if ($workoutModel) {
                $workoutModel->name = $workout->name();
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
            $workout = \App\Modules\WorkoutCategory\Infrastructure\Database\Models\WorkoutCategory::findOrFail($id);

            $workout->delete();
        } catch (Exception $e) {
            Log::error('Error deleting workout', [
                'error' => $e->getMessage(),
                'data' => $id,
            ]);
            throw $e;
        }
    }


    public function getWorkoutsByUserId(int $userId): WorkoutCategoryList
    {
        $workoutModels = \App\Modules\WorkoutCategory\Infrastructure\Database\Models\WorkoutCategory::where('user_id', $userId)->get();

        $items = $workoutModels->map(fn ($workoutModel) => new WorkoutCategory(
            id: $workoutModel->id,
            name: $workoutModel->name,
            userId: $workoutModel->user_id,
        ))->toArray();

        return new WorkoutCategoryList($items);
    }
}
