<?php

namespace App\Services;

use App\Models\Exercise;
use App\Models\Workout;
use Illuminate\Support\Facades\Log;

class ExerciseService
{
    public function create(Exercise $exercise): void
    {
        try {
            $this->validate($exercise);
            $exercise->save();
        } catch (\Exception $e) {
            Log::error('Error creating workout', [
                'error' => $e->getMessage(),
                'data' => $data ?? null,
            ]);
            throw $e;
        }
    }

    public function update(Exercise $exercise)
    {
        try {
            $this->validate($exercise);

            $exercise->save();
        } catch (\Exception $e) {
            Log::error('Error updating workout', [
                'error' => $e->getMessage(),
                'data' => $exercise,
            ]);
            throw $e;
        }
    }

    public function delete(int $id)
    {
        try {
            $exercise = Exercise::findOrFail($id);

            if ($exercise->workout->user_id !== auth()->id()) {
                throw new \Exception('Unauthorized action');
            }

            $exercise->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting workout', [
                'error' => $e->getMessage(),
                'data' => $id,
            ]);
            throw $e;
        }
    }

    public function userExercises()
    {
        $workoutIds = auth()->user()->workouts->pluck('id');

        return Exercise::whereIn('workout_id', $workoutIds)->with('workout');
    }

    private function validate(Exercise $exercise): void
    {
        if (empty($exercise->name)) {
            throw new \InvalidArgumentException('Name cannot be empty');
        }

        if (empty($exercise->workout_id)) {
            throw new \InvalidArgumentException('Workout ID cannot be empty');
        }

        $workout = Workout::find($exercise->workout_id);
        if ($workout?->user_id !== auth()->id()) {
            throw new \InvalidArgumentException('Workout not found');
        }
    }
}
