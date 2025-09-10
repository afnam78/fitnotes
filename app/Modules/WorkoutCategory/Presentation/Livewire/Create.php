<?php

declare(strict_types=1);

namespace App\Modules\WorkoutCategory\Presentation\Livewire;

use App\Modules\WorkoutCategory\Application\Commands\CreateWorkoutCategoryCommand;
use App\Modules\WorkoutCategory\Application\UseCases\CreateWorkoutCategoryUseCase;
use App\Modules\WorkoutCategory\Domain\Exceptions\WorkoutCategoryMustBeUnique;
use Exception;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

final class Create extends Component
{
    use Toastable;

    public ?string $name = null;

    protected array $rules = [
        'name' => 'required|string|max:255',
    ];

    public function render()
    {
        return view('workout-category::livewire.create');
    }

    public function create(CreateWorkoutCategoryUseCase $useCase): void
    {

        try {
            $this->validate();

            $command = new CreateWorkoutCategoryCommand(
                name: $this->name,
                userId: auth()->id(),
            );

            $useCase->handle($command);

            redirect(route('workout-category'))->success(
                'Entrenamiento creado correctamente',
            );

        } catch (WorkoutCategoryMustBeUnique $e) {
            $this->error('El nombre ya existe');
        } catch (Exception $e) {
            $this->error('Error al crear el entrenamiento');
        }
    }
}
