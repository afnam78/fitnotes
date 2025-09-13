<?php

declare(strict_types=1);

namespace App\Modules\Shared\Infrastructure\Repositories;

use App\Modules\Exercise\Infrastructure\Database\Models\Exercise;
use App\Modules\Set\Infrastructure\Database\Models\Set;
use App\Modules\Shared\Domain\Contracts\DashboardRepositoryInterface;
use App\Modules\Shared\Domain\Helpers\LogHelper;
use App\Modules\Workout\Infrastructure\Database\Models\Workout;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class DashboardRepository implements DashboardRepositoryInterface
{
    public function getWorkoutsCountToday(int $userId): int
    {
        try {
            return Workout::with('exercises.sets')
                ->where('user_id', $userId)
                ->whereHas('exercises.sets', function ($query): void {
                    $query->whereDate('set_date', now()->format('Y-m-d'));
                })
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

            throw $e;
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

            throw $e;
        }
    }

    public function getWeeklyRecordsExercises(int $userId): array
    {
        $startDate = now()->startOfWeek()->format('Y-m-d');
        $endDate = now()->endOfWeek()->format('Y-m-d');

        $exerciseIds = Exercise::whereHas('workout', fn ($q) => $q->where('user_id', $userId))
            ->pluck('id');

        $historicalSets = Set::whereIn('exercise_id', $exerciseIds)
            ->where('set_date', '<', $startDate)
            ->get()
            ->groupBy('exercise_id');

        $weeklySets = Set::whereIn('exercise_id', $exerciseIds)
            ->whereBetween('set_date', [$startDate, $endDate])
            ->get();

        $newRecords = [];

        foreach ($weeklySets as $set) {
            $exerciseHistory = $historicalSets[$set->exercise_id] ?? collect();

            if ($exerciseHistory->isEmpty()) {
                $newRecords[] = [
                    'type' => 'Primer Set',
                    'exercise_id' => $set->exercise_id,
                    'weight' => $set->weight,
                    'reps' => $set->reps,
                    'set_date' => $set->set_date,
                ];
                continue;
            }

            $maxHistoricalWeight = $exerciseHistory->max('weight');
            $maxHistoricalRepsAtWeight = $exerciseHistory->where('weight', $set->weight)->max('reps');

            if ($set->weight > $maxHistoricalWeight) {
                $newRecords[] = [
                    'type' => 'Nuevo Récord de Peso',
                    'exercise_id' => $set->exercise_id,
                    'weight' => $set->weight,
                    'reps' => $set->reps,
                    'set_date' => $set->set_date,
                ];
            }

            if ($set->reps > $maxHistoricalRepsAtWeight) {
                $newRecords[] = [
                    'type' => 'Nuevo Récord de Repeticiones',
                    'exercise_id' => $set->exercise_id,
                    'weight' => $set->weight,
                    'reps' => $set->reps,
                    'set_date' => $set->set_date,
                ];
            }
        }

        $exercisesWithRecords = collect($newRecords)
            ->pluck('exercise_id')
            ->unique();

        $result = Exercise::whereIn('id', $exercisesWithRecords->values())->pluck('name')->toArray();

        return array_slice($result, 0, 3);
    }

    public function getExerciseLineChartProgress(Exercise $exercise): array
    {
        $startDate = Carbon::now()->subMonths(6)->toDateString();
        $endDate = Carbon::now()->toDateString();

        $records = Set::query()
            ->select('s.set_date', 's.weight', 's.reps')
            ->from('sets as s')
            ->join(DB::raw('(
            SELECT set_date, MAX(weight) as max_weight
            FROM sets
            WHERE exercise_id = ' . $exercise->id . '
              AND set_date BETWEEN "' . $startDate . '" AND "' . $endDate . '"
            GROUP BY set_date
        ) as m'), function ($join): void {
                $join->on('s.set_date', '=', 'm.set_date')
                    ->on('s.weight', '=', 'm.max_weight');
            })
            ->where('s.exercise_id', $exercise->id)
            ->whereBetween('s.set_date', [$startDate, $endDate])
            ->orderBy('s.set_date')
            ->get();

        $dataPoints = $records->map(
            fn ($record) =>
        round($record->weight * (1 + ($record->reps / 30)), 2)
        );

        $labels = $records->pluck('set_date')->map(
            fn ($date) =>
        Carbon::parse($date)->format('d/m/Y')
        );

        return [
            'labels' => $labels,
            'dataPoints' => $dataPoints,
            'title' => $exercise->name,
        ];
    }


    private function getWeekQuery(int $userId): Builder
    {
        $firstOfCurrentWeek = now()->startOfWeek()->format('Y-m-d');
        $lastOfCurrentWeek = now()->endOfWeek()->format('Y-m-d');

        return Set::with('exercise.workout')
            ->whereHas('exercise.workout', function ($query): void {
                $query->where('user_id', auth()->id());
            })
            ->whereBetween('set_date', [$firstOfCurrentWeek, $lastOfCurrentWeek]);
    }
}
