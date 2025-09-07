<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Infrastructure\Repositories;

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

    public function findByIdAndUserId(int $exerciseId, int $userId): ?Exercise
    {
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
    }

}
