<?php

declare(strict_types=1);

namespace App\Modules\Workout\Presentation\Livewire;

use App\Services\WorkoutService;
use Exception;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

final class Table extends Component
{
    use Toastable;

    private WorkoutService $service;

    public function render()
    {
        return view('workout::livewire.table', [
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
                'Entrenamiento eliminado correctamente',
            );
        } catch (Exception $e) {
            $this->error('Error al eliminar el entrenamiento');
        }
    }
}
