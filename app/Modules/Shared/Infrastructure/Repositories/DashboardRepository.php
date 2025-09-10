<?php

declare(strict_types=1);

namespace App\Modules\Shared\Infrastructure\Repositories;

use App\Modules\Exercise\Infrastructure\Database\Models\Exercise;
use App\Modules\Set\Infrastructure\Database\Models\Set;
use App\Modules\Shared\Domain\Contracts\DashboardRepositoryInterface;
use App\Modules\Shared\Domain\Helpers\LogHelper;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

final class DashboardRepository implements DashboardRepositoryInterface
{
    public function getWorkoutsCountToday(int $userId): int
    {
        try {
            return Exercise::with('workout')
                ->whereHas('workout', function ($query) use ($userId): void {
                    $query->where('user_id', $userId)
                        ->whereDate('date', now()->format('Y-m-d'));
                })
                ->distinct()
                ->count();

        } catch (Exception $e) {
            Log::error('Error getting workouts count today', LogHelper::body(
                exception: $e,
                class: self::class,
                method: __METHOD__,
                data: [
                    'userId' => $userId,
                ],
            ));

            throw $e;
        }
    }

    public function getCurrentWeekSetsCount(int $userId): int
    {
        try {
            return $this->getWeekQuery($userId)->count();
        } catch (Exception $e) {
            Log::error($e->getMessage(), LogHelper::body(
                exception: $e,
                class: __CLASS__,
                method: __METHOD__,
                data: [
                    'userID' => $userId
                ]
            ));
        }
    }

    public function getWeeklyVolume(int $userId): float
    {
        try {
            return (float) $this->getWeekQuery($userId)->sum('weight');
        } catch (Exception $e) {
            Log::error($e->getMessage(), LogHelper::body(
                exception: $e,
                class: __CLASS__,
                method: __METHOD__,
                data: [
                    'userID' => $userId
                ]
            ));
        }
    }

    private function getWeekQuery(int $userId): Builder
    {
        $firstOfCurrentWeek = now()->startOfWeek()->format('Y-m-d');
        $lastOfCurrentWeek = now()->endOfWeek()->format('Y-m-d');

        return Set::with('exercise.workout')
            ->whereHas('exercise.workout', function ($query) use ($firstOfCurrentWeek, $lastOfCurrentWeek, $userId): void {
                $query->where('user_id', $userId)
                    ->whereBetween('date', [$firstOfCurrentWeek, $lastOfCurrentWeek]);
            });
    }
}
