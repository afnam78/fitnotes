<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Domain\Contracts;

use Illuminate\Support\Carbon;

interface WorkoutCategoryRepositoryInterface
{
    public function getRegistersByDate(int $userId, Carbon $date): array;

    public function getWorkoutWithRelatedExercises(int $workoutId, int $userId): array;
}
