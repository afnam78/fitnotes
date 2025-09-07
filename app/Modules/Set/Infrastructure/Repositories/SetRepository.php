<?php

declare(strict_types=1);

namespace App\Modules\Set\Infrastructure\Repositories;

use App\Modules\Exercise\Domain\Entities\Exercise;
use App\Modules\Set\Domain\Contracts\SetRepositoryInterface;
use App\Modules\Set\Domain\Entities\Set;
use App\Modules\Shared\Domain\Helpers\LogHelper;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

final class SetRepository implements SetRepositoryInterface
{
    public function create(Set $set): void
    {
        try {
            \App\Modules\Set\Infrastructure\Database\Models\Set::create(
                [
                    'exercise_id' => $set->exerciseId(),
                    'reps' => $set->reps(),
                    'weight' => $set->weight(),
                    'order' => $set->order(),
                    'set_date' => $set->date()->format('Y-m-d'),
                ]
            );
        } catch (Exception $e) {
            Log::error($e->getMessage(), LogHelper::body(
                exception: $e,
                class: __CLASS__,
                method: __METHOD__,
                data: [
                    'set' => $set,
                ]
            ));

            throw $e;
        }
    }

    public function getLasOrder(Exercise $exercise, Carbon $date): int
    {
        try {
            $order = \App\Modules\Exercise\Infrastructure\Database\Models\Exercise::with('sets')
                ->find($exercise->id())
                ->sets()
                ->where(fn ($query) => $query->where('set_date', $date->format('Y-m-d')))
                ->max('order');

            return (null === $order ? 0 : $order) + 1;
        } catch (Exception $e) {
            Log::error($e->getMessage(), LogHelper::body(
                exception: $e,
                class: __CLASS__,
                method: __METHOD__,
                data: [
                    'set' => $set,
                ]
            ));

            throw $e;
        }
    }
}
