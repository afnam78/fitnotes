<?php

declare(strict_types=1);

namespace App\Modules\Set\Infrastructure\Repositories;

use App\Modules\Exercise\Infrastructure\Database\Models\Exercise;
use App\Modules\Set\Domain\Contracts\SetRepositoryInterface;
use App\Modules\Set\Domain\Entities\Set;
use App\Modules\Shared\Domain\Helpers\LogHelper;
use App\Modules\Workout\Infrastructure\Database\Models\Workout;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

final class SetRepository implements SetRepositoryInterface
{
    public function add(
        int $userId,
        Set $set,
        Carbon $date,
    ): void {
        try {
            $workout = Workout::firstOrCreate([
                'user_id' => $userId,
                'date' => $date->format('Y-m-d'),
            ]);

            $exerciseOrder = $workout->exercises()->max('order') + 1;

            $exercise = Exercise::firstOrCreate([
                'workout_id' => $workout->id,
                'exercise_catalog_id' => $set->exerciseCatalogId(),
                'order' => $exerciseOrder,
            ]);

            $setOrder = $exercise->sets()->max('order') + 1;

            \App\Modules\Set\Infrastructure\Database\Models\Set::create([
                'exercise_id' => $exercise->id,
                'weight' => $set->weight(),
                'reps' => $set->reps(),
                'order' => $setOrder
            ]);

        } catch (Exception $exception) {
            Log::error(
                $exception->getMessage(),
                LogHelper::body($exception, __CLASS__, __METHOD__, ['set' => $set]),
            );
            ;
        }
    }
}
