<?php

declare(strict_types=1);

namespace App\Modules\ExerciseCatalog\Presentation\Livewire;

use App\Modules\ExerciseCatalog\Application\Commands\DeleteExerciseCatalogCommand;
use App\Modules\ExerciseCatalog\Application\UseCases\DeleteExerciseCatalogUseCase;
use Exception;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

final class Table extends Component
{
    use Toastable;


    public function render()
    {
        return view('exercise-catalog::livewire.table', [
            'exercises' => auth()->user()->exerciseCatalogs()->paginate(10),
        ]);
    }

    public function delete(int $id, DeleteExerciseCatalogUseCase $useCase): void
    {
        try {
            $command = new DeleteExerciseCatalogCommand(
                id: $id,
                userId: auth()->id(),
            );

            $useCase->handle($command);

            $this->success(
                'Ejercicio eliminado correctamente'
            );
        } catch (Exception $e) {
            $this->error('Error al eliminar el ejercicio');
        }
    }
}
