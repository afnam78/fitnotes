<?php

declare(strict_types=1);

namespace App\Modules\Workout\Presentation\Livewire;

use App\Models\Workout;
use App\Services\WorkoutService;
use Exception;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

final class Update extends Component
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
        return view('workout::livewire.update');
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
                'Entrenamiento actualizado correctamente',
            );
        } catch (Exception $e) {
            $this->error('Error al actualizar el entrenamiento');
        }
    }
}
