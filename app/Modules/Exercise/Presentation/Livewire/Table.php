<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Presentation\Livewire;

use App\Modules\Exercise\Application\Commands\DeleteExerciseCommand;
use App\Modules\Exercise\Application\Commands\GetUserWorkoutsCommand;
use App\Modules\Exercise\Application\UseCases\DeleteExerciseUseCase;
use App\Modules\Workout\Application\UseCases\GetUserWorkoutsUseCase;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toastable;

final class Table extends Component
{
    use Toastable;
    use WithPagination;

    public string $search = '';
    public ?int $selectedWorkout = null;
    public array $workouts = [];

    public function render()
    {
        return view('exercise::livewire.table', [
            'exercises' => auth()->user()->exercises()
                ->with('workout')
                ->select(['exercises.id as exercise_id', 'exercises.name as exercise_name', 'exercises.workout_id'])
                ->when( ! empty($this->search), fn ($query) => $query->where('exercises.name', 'like', '%' . $this->search . '%'))
                ->when($this->selectedWorkout, fn ($query) => $query->where('exercises.workout_id', $this->selectedWorkout))
                ->paginate(10)
        ]);
    }

    public function mount(GetUserWorkoutsUseCase $useCase): void
    {
        $command = new GetUserWorkoutsCommand(auth()->id());
        $this->workouts = $useCase->handle($command)->toArray();
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
