<?php

declare(strict_types=1);

namespace App\Modules\Workout\Infrastructure\Repositories;

use App\Modules\Shared\Domain\Helpers\LogHelper;
use App\Modules\Workout\Domain\Entities\Workout;
use Exception;
use Illuminate\Support\Facades\Log;

final class WorkoutRepository
{
    public function create(Workout $workout): void
    {
        try {
            \App\Models\Workout::create([
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
}
