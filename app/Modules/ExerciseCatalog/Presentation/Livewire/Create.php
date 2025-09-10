<?php

declare(strict_types=1);

namespace App\Modules\ExerciseCatalog\Presentation\Livewire;

use App\Modules\ExerciseCatalog\Application\Commands\CreateExerciseCatalogCommand;
use App\Modules\ExerciseCatalog\Application\Commands\GetUserWorkoutsCommand;
use App\Modules\ExerciseCatalog\Application\UseCases\CreateExerciseCatalogUseCase;
use App\Modules\WorkoutCategory\Application\UseCases\GetUserWorkoutCategoriesUseCase;
use Exception;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

final class Create extends Component
{
    use Toastable;

    public ?string $name = null;
    public ?int $workoutCategoryId = null;
    public array $workoutCategories = [];

    protected array $rules = [
        'name' => 'required|string|max:255',
        'workoutCategoryId' => 'required|exists:workout_categories,id',
    ];

    public function render()
    {
        return view('exercise-catalog::livewire.create');
    }

    public function mount(GetUserWorkoutCategoriesUseCase $useCase): void
    {
        $command = new GetUserWorkoutsCommand(auth()->id());

        $workoutCategories = $useCase->handle($command);

        $this->workoutCategories = $workoutCategories->toArray();
    }

    public function create(CreateExerciseCatalogUseCase $useCase): void
    {

        $this->validate();

        try {
            $command = new CreateExerciseCatalogCommand(
                name: $this->name,
                workoutId: $this->workoutCategoryId,
                userId: auth()->id(),
            );

            $useCase->handle($command);

            redirect(route('exercise-catalog'))->success(
                'Creado correctamente.'
            );
        } catch (Exception $e) {
            $this->error('Error al crear el ejercicio', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
