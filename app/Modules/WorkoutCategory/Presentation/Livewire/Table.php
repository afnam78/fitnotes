<?php

declare(strict_types=1);

namespace App\Modules\WorkoutCategory\Presentation\Livewire;

use App\Modules\WorkoutCategory\Application\Commands\DeleteWorkoutCategoryCommand;
use App\Modules\WorkoutCategory\Application\UseCases\DeleteWorkoutCategoryUseCase;
use Exception;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

final class Table extends Component
{
    use Toastable;

    public function render()
    {
        return view('workout-category::livewire.table', [
            'workouts' => auth()->user()->workoutCategories()->select(['id', 'name'])->paginate(10),
        ]);
    }

    public function delete(int $id, DeleteWorkoutCategoryUseCase $useCase): void
    {
        try {
            $command = new DeleteWorkoutCategoryCommand(
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
