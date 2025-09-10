<?php

declare(strict_types=1);

namespace App\Modules\ExerciseCatalog\Infrastructure\Repositories;

use App\Modules\ExerciseCatalog\Domain\Contracts\ExerciseCatalogRepositoryInterface;
use App\Modules\ExerciseCatalog\Domain\Entities\ExerciseCatalog;
use App\Modules\Shared\Domain\Helpers\LogHelper;
use Exception;
use Illuminate\Support\Facades\Log;

final class ExerciseCatalogRepository implements ExerciseCatalogRepositoryInterface
{
    public function create(ExerciseCatalog $exercise): void
    {
        try {
            \App\Modules\ExerciseCatalog\Infrastructure\Database\Models\ExerciseCatalog::create([
                'name' => $exercise->name(),
                'workout_category_id' => $exercise->workoutCategoryId(),
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

    public function update(ExerciseCatalog $exercise): void
    {
        try {
            $exerciseModel = \App\Modules\ExerciseCatalog\Infrastructure\Database\Models\ExerciseCatalog::where('id', $exercise->id())
                ->firstOrFail();

            $exerciseModel->name = $exercise->name();
            $exerciseModel->workout_category_id = $exercise->workoutCategoryId();
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

    public function findByIdAndUserId(int $exerciseId, int $userId): ?ExerciseCatalog
    {
        try {
            $exerciseModel = \App\Modules\ExerciseCatalog\Infrastructure\Database\Models\ExerciseCatalog::with('workoutCategory')
                ->where('id', $exerciseId)
                ->whereHas('workoutCategory', function ($query) use ($userId): void {
                    $query->where('user_id', $userId);
                })
                ->first();

            if ( ! $exerciseModel) {
                return null;
            }

            return new ExerciseCatalog(
                id: $exerciseModel->id,
                name: $exerciseModel->name,
                workoutCategoryId: $exerciseModel->workout_category_id,
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
            $exerciseModels = \App\Modules\ExerciseCatalog\Infrastructure\Database\Models\ExerciseCatalog::with('workoutCategory')
                ->whereHas('workoutCategory', function ($query) use ($userId): void {
                    $query->where('user_id', $userId);
                })
                ->where('workout_category_id', $workoutId)
                ->get();

            return $exerciseModels->map(fn ($exerciseModel) => new ExerciseCatalog(
                id: $exerciseModel->id,
                name: $exerciseModel->name,
                workoutCategoryId: $exerciseModel->workout_category_id,
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

    public function delete(ExerciseCatalog $exercise): void
    {
        try {
            $exerciseModel = \App\Modules\ExerciseCatalog\Infrastructure\Database\Models\ExerciseCatalog::where('id', $exercise->id())
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
