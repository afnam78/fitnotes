<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Presentation\Livewire;

use App\Modules\Exercise\Application\Commands\DeleteExerciseCommand;
use App\Modules\Exercise\Application\UseCases\DeleteExerciseUseCase;
use Exception;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

final class Table extends Component
{
    use Toastable;


    public function render()
    {
        return view('exercise::livewire.table', [
            'exercises' => auth()->user()->exercises()->paginate(10),
        ]);
    }

    public function delete(int $id, DeleteExerciseUseCase $useCase): void
    {
        try {
            $command = new DeleteExerciseCommand(
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
