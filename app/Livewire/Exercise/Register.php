<?php

namespace App\Livewire\Exercise;

use App\Models\Exercise;
use App\Models\Workout;
use Illuminate\Support\Collection;
use Livewire\Component;

class Register extends Component
{
    public Exercise $selectedExercise;
    public Collection $workouts;
    public ?int $selectedWorkoutId = null;
    public Collection $exercises;

    protected array $rules = [
        'selectedExercise' => 'required|exists:exercises,id',
        'selectedWorkout' => 'required|exists:workouts,id',
    ];

    public function updated($key, $value)
    {
        if ($key === 'selectedWorkoutId') {
            $this->exercises = Workout::find($value)->load('exercises')->exercises;
        }
    }

    public function render()
    {
        return view('livewire.exercise.register');
    }

    public function mount(?string $date = null): void
    {
        $this->exerciseDate = $date ?? now()->format('Y-m-d');
        $this->workouts = auth()->user()->workouts;
    }
}
