<?php

namespace App\Livewire\Exercise;

use App\Models\Exercise;
use App\Services\ExerciseService;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

class Update extends Component
{
    use Toastable;

    public Exercise $exercise;

    protected array $rules = [
        'exercise.name' => 'required|string|max:255',
        'exercise.description' => 'nullable|string|max:1000',
        'exercise.workout_id' => 'required|exists:workouts,id',
    ];

    private ExerciseService $service;

    public function render()
    {
        return view('livewire.exercise.update', [
            'workouts' => auth()->user()->workouts,
        ]);
    }

    public function mount(Exercise $exercise): void
    {
        $this->exercise = $exercise;
    }

    public function boot(): void
    {
        $this->service = app()->make(ExerciseService::class);
    }

    public function create(): void
    {

        try {
            $this->validate();
            $this->service->create($this->exercise);

            redirect(route('exercise'))->success(
                'Entrenamiento creado correctamente'
            );
        } catch (\Exception $e) {
            $this->error('Error al crear el entrenamiento', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
