<?php

declare(strict_types=1);

namespace App\Modules\Set\Infrastructure\Repositories;

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

    public function update(Set $set): void
    {
        try {
            $result = \App\Modules\Set\Infrastructure\Database\Models\Set::find($set->id());

            $result->update(
                [
                    'reps' => $set->reps(),
                    'weight' => $set->weight(),
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

    public function delete(Set $set): void
    {
        try {
            \App\Modules\Set\Infrastructure\Database\Models\Set::destroy($set->id());
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

    public function findByIdAndUserId(int $id, int $userId): ?Set
    {
        try {
            $data = \App\Modules\Set\Infrastructure\Database\Models\Set::with('exercise.workout')
                ->where('id', $id)
                ->whereHas('exercise.workout', function ($query) use ($userId): void {
                    $query->where('user_id', $userId);
                })
                ->first();

            if ( ! $data) {
                return null;
            }

            return new Set(
                id: $data->id,
                exerciseId: $data->exercise_id,
                reps: $data->reps,
                weight: (float) $data->weight,
                date: Carbon::parse($data->set_date),
            );
        } catch (Exception $e) {
            Log::error($e->getMessage(), LogHelper::body(
                exception: $e,
                class: __CLASS__,
                method: __METHOD__,
                data: [
                    'id' => $id,
                    'userId' => $userId,
                ]
            ));

            throw $e;
        }
    }
}
