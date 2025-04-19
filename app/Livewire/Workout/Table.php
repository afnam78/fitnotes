<?php

namespace App\Livewire\Workout;

use App\Services\WorkoutService;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

class Table extends Component
{
    use Toastable;

    private WorkoutService $service;

    public function render()
    {
        return view('livewire.workout.table', [
            'workouts' => auth()->user()->workouts()->select(['id', 'name'])->paginate(10),
        ]);
    }

    public function boot(): void
    {
        $this->service = app()->make(WorkoutService::class);
    }

    public function delete(int $id): void
    {
        try {
            $this->service->delete($id);
            $this->success(
                'Entrenamiento eliminado correctamente'
            );
        } catch (\Exception $e) {
            $this->error('Error al eliminar el entrenamiento');
        }
    }
}
