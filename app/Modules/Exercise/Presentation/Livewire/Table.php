<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Presentation\Livewire;

use App\Services\ExerciseService;
use Exception;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

final class Table extends Component
{
    use Toastable;

    private ExerciseService $service;

    public function render()
    {
        return view('exercise::livewire.table', [
            'exercises' => auth()->user()->exercises()->paginate(10),
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
        } catch (Exception $e) {
            $this->error('Error al eliminar el ejercicio');
        }
    }
}
