<?php

namespace App\Livewire\Workout;

use App\Models\Workout;
use App\Services\WorkoutService;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

class Update extends Component
{
    use Toastable;

    public Workout $workout;

    private WorkoutService $service;

    protected array $rules = [
        'workout.name' => 'required|string|max:255',
        'workout.description' => 'nullable|string|max:1000',
    ];

    public function render()
    {
        return view('livewire.workout.update');
    }

    public function mount(Workout $workout): void
    {
        $this->workout = $workout;
    }

    public function boot(): void
    {
        $this->service = app()->make(WorkoutService::class);
    }

    public function update(): void
    {
        $this->validate();
        try {
            $this->service->update($this->workout);

            redirect(route('workout'))->success(
                'Entrenamiento actualizado correctamente'
            );
        } catch (\Exception $e) {
            $this->error('Error al actualizar el entrenamiento');
        }
    }
}
