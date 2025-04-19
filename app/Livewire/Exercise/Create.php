<?php

namespace App\Livewire\Exercise;

use App\Models\Exercise;
use App\Services\ExerciseService;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

class Create extends Component
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
        return view('livewire.exercise.create', [
            'workouts' => auth()->user()->workouts,
        ]);
    }

    public function mount(): void
    {
        $this->exercise = new Exercise;
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
                'Ejercicio creado correctamente'
            );
        } catch (\Exception $e) {
            $this->error('Error al crear el ejercicio', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
