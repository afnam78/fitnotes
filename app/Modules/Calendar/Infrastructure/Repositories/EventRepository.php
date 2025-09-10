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
                ->with('exercise.workout', 'exercise.exerciseCatalog.workoutCategory')
                ->whereHas('exercise.workout', function ($query): void {
                    $query->where('user_id', auth()->id());
                })
                ->distinct()
                ->get()
                ->map(fn (Set $item) => new Event(
                    start: Carbon::parse($item->exercise->workout->date),
                    title: $item->exercise->exerciseCatalog->workoutCategory->name,
                    id: $item->id,
                ))
                ->unique(fn (Event $item) => $item->start()->format('d/m/y') . $item->title())
                ->values()
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
