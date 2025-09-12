<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Infrastructure\Repositories;

use App\Modules\Calendar\Domain\Contracts\EventRepositoryInterface;
use App\Modules\Calendar\Domain\Entities\Event;
use App\Modules\Set\Infrastructure\Database\Models\Set;
use App\Modules\Shared\Domain\Helpers\LogHelper;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

final class EventRepository implements EventRepositoryInterface
{
    public function getWorkoutEvents(int $userId): array
    {
        try {
            return Set::query()
                ->join('exercises', 'exercises.id', '=', 'sets.exercise_id')
                ->join('workouts', 'workouts.id', '=', 'exercises.workout_id')
                ->where('workouts.user_id', $userId)
                ->selectRaw('
                MIN(sets.id) as id,
                sets.set_date,
                workouts.name as workout_name,
                DATE_FORMAT(sets.set_date, "%d/%m/%y") as formatted_date
            ')
                ->groupBy('formatted_date', 'workout_name', 'sets.set_date')
                ->get()
                ->map(fn ($item) => new Event(
                    start: Carbon::parse($item->set_date),
                    title: $item->workout_name,
                    id: $item->id,
                ))
                ->map(fn ($item) => (object) $item)
                ->toArray();
        } catch (Exception $e) {
            Log::error($e->getMessage(), LogHelper::body(
                exception: $e,
                class: __CLASS__,
                method: __METHOD__,
                data: ['userId' => $userId]
            ));
            throw $e;
        }
    }
}
