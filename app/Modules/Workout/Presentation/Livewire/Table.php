<?php

declare(strict_types=1);

namespace App\Modules\Workout\Presentation\Livewire;

use App\Modules\Workout\Application\Commands\DeleteWorkoutCommand;
use App\Modules\Workout\Application\UseCases\DeleteWorkoutUseCase;
use Exception;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

final class Table extends Component
{
    use Toastable;

    public function render()
    {
        return view('workout::livewire.table', [
            'workouts' => auth()->user()->workouts()->select(['id', 'name'])->paginate(10),
        ]);
    }

    public function delete(int $id, DeleteWorkoutUseCase $useCase): void
    {
        try {
            $command = new DeleteWorkoutCommand(
                workoutId: $id,
                userId: auth()->id(),
            );

            $useCase->handle($command);

            $this->success(
                'Entrenamiento eliminado correctamente',
            );
        } catch (Exception $e) {
            $this->error('Error al eliminar el entrenamiento');
        }
    }
}
