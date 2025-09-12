<?php

declare(strict_types=1);

namespace App\Modules\Shared\Domain\Contracts;

use App\Modules\Exercise\Infrastructure\Database\Models\Exercise;

interface DashboardRepositoryInterface
{
    public function getWorkoutsCountToday(int $userId): int;

    public function getCurrentWeekSetsCount(int $userId): int;

    public function getWeeklyVolume(int $userId): float;

    public function getWeeklyRecordsExercises(int $userId): array;

    public function getExerciseLineChartProgress(Exercise $exercise): array;
}
