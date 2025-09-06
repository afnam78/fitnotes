<?php

namespace App\Livewire\Exercise;

use App\Services\ExerciseService;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

class Table extends Component
{
    use Toastable;

    private ExerciseService $service;

    public function render()
    {
        return view('livewire.exercise.table', [
            'exercises' => $this->service->userExercises()->paginate(10),
        ]);
    }

    public function boot(): void
    {
        $this->service = app()->make(ExerciseService::class);
    }

    public function delete(int $id): void
    {
        try {
            $this->service->delete($id);
            $this->success(
                'Ejercicio eliminado correctamente'
            );
        } catch (\Exception $e) {
            $this->error('Error al eliminar el ejercicio');
        }
    }
}
