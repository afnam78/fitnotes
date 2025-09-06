<?php

namespace App\Livewire\Exercise;

use App\Models\Exercise;
use App\Models\Workout;
use Illuminate\Support\Collection;
use Livewire\Component;

class Register extends Component
{
    public ?Exercise $selectedExercise = null;
    public ?Workout $selectedWorkout = null;

    public Collection $workouts;
    public ?int $selectedWorkoutId = null;
    public ?int $selectedExerciseId = null;
    public Collection $exercises;
    public string $exerciseDate;

    public string $title;

    public int $step = 1;

    protected array $rules = [
        'exerciseDate' => 'required|date',
        'selectedExerciseId' => 'required|exists:exercises,id',
        'selectedWorkoutId' => 'required|exists:workouts,id',
    ];

    public function render()
    {
        return view('livewire.exercise.register');
    }

    public function mount(?string $date = null): void
    {
        $this->exerciseDate = $date ?? now()->format('Y-m-d');
        $this->workouts = auth()->user()->workouts;
        $this->exercises = collect();
        $this->title = 'Seleccionar entrenamiento';
    }

    public function nextStep(): void
    {
        if($this->step === 1) {
            $this->stepOne();
        }

        if ($this->step === 2)
        {
            $this->stepTwo();
        }

        $this->step++;
    }

    public function create()
    {

    }

    private function stepOne():void
    {
        $this->validate([
            'selectedWorkoutId' => 'required|exists:workouts,id',
            'exerciseDate' => 'required|date',
        ]);
        $this->selectedWorkout = Workout::find($this->selectedWorkoutId);
        $this->exercises = $this->selectedWorkout->load('exercises')->exercises;
        $this->title = sprintf(
            '%s',
            $this->selectedWorkout->name,
        );
    }

    private function stepTwo(): void
    {
        $this->validate([
            'selectedExerciseId' => 'required|exists:exercises,id',
        ]);
        $this->selectedExercise = Exercise::find($this->selectedExerciseId);

        $this->title = sprintf(
            "%s\n%s",
            $this->selectedWorkout->name,
            $this->selectedExercise->name
        );
    }
}
