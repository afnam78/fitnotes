<?php

declare(strict_types=1);

namespace App\Modules\WorkoutCategory\Presentation\Livewire;

use App\Modules\WorkoutCategory\Application\Commands\GetWorkoutCategoryDetailsCommand;
use App\Modules\WorkoutCategory\Application\Commands\UpdateWorkoutCategoryCommand;
use App\Modules\WorkoutCategory\Application\UseCases\GetWorkoutCategoryDetailsUseCase;
use App\Modules\WorkoutCategory\Application\UseCases\UpdateWorkoutCategoryUseCase;
use App\Modules\WorkoutCategory\Domain\Exceptions\WorkoutCategoryMustBeUnique;
use Exception;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

final class Update extends Component
{
    use Toastable;

    public int $workoutId;
    public string $name;

    protected array $rules = [
        'name' => 'required|string|max:255',
    ];

    public function render()
    {
        return view('workout-category::livewire.update');
    }

    public function mount(int $id, GetWorkoutCategoryDetailsUseCase $useCase): void
    {
        $this->workoutId = $id;

        $command = new GetWorkoutCategoryDetailsCommand($this->workoutId, auth()->id());
        $workout = $useCase->handle($command);

        $this->name = $workout->name;
    }

    public function update(UpdateWorkoutCategoryUseCase $useCase): void
    {
        $this->validate();

        try {
            $command = new UpdateWorkoutCategoryCommand(
                workoutId: $this->workoutId,
                userId: auth()->id(),
                name: $this->name,
            );

            $useCase->handle($command);

            redirect(route('workout-category'))
                ->success('Actualizado correctamente');

        } catch (WorkoutCategoryMustBeUnique $e) {
            $this->error('El nombre ya existe');
        } catch (Exception $e) {
            $this->error('Error al actualizar el entrenamiento');
        }
    }
}
