<?php

namespace App\Livewire\Workout;

use App\Models\Workout;
use App\Services\WorkoutService;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

class Create extends Component
{
    use Toastable;

    public Workout $workout;

    protected array $rules = [
        'workout.name' => 'required|string|max:255',
        'workout.description' => 'nullable|string|max:1000',
    ];

    private WorkoutService $service;

    public function render()
    {
        return view('livewire.workout.create');
    }

    public function mount(): void
    {
        $this->workout = new Workout;
    }

    public function boot(): void
    {
        $this->service = app()->make(WorkoutService::class);
    }

    public function create(): void
    {

        try {
            $this->validate();
            $this->service->create($this->workout);

            redirect(route('workout'))->success(
                'Entrenamiento creado correctamente'
            );
        } catch (\Exception $e) {
            $this->error('Error al crear el entrenamiento', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
