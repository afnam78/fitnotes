<?php

namespace App\Services;

use App\Models\Workout;
use Illuminate\Support\Facades\Log;

class WorkoutService
{
    public function create(Workout $workout): void
    {
        try {
            if (empty($workout->name)) {
                throw new \InvalidArgumentException('Name cannot be empty');
            }

            $workout->user_id = auth()->id();
            $workout->save();
        } catch (\Exception $e) {
            Log::error('Error creating workout', [
                'error' => $e->getMessage(),
                'data' => $data ?? null,
            ]);
            throw $e;
        }
    }

    public function update(Workout $workout)
    {
        try {
            if (empty($workout->name)) {
                throw new \InvalidArgumentException('Name cannot be empty');
            }

            $workout->save();
        } catch (\Exception $e) {
            Log::error('Error updating workout', [
                'error' => $e->getMessage(),
                'data' => $workout,
            ]);
            throw $e;
        }
    }

    public function delete(int $id)
    {
        try {
            $workout = Workout::findOrFail($id);

            if ($workout->user_id !== auth()->id()) {
                throw new \Exception('Unauthorized action');
            }

            $workout->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting workout', [
                'error' => $e->getMessage(),
                'data' => $id,
            ]);
            throw $e;
        }
    }
}
