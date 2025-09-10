<?php

declare(strict_types=1);

namespace App\Modules\ExerciseCatalog\Presentation\Livewire;

use App\Modules\ExerciseCatalog\Application\Commands\GetExerciseCatalogDetailsCommand;
use App\Modules\ExerciseCatalog\Application\Commands\GetUserWorkoutsCommand;
use App\Modules\ExerciseCatalog\Application\Commands\UpdateExerciseCatalogCommand;
use App\Modules\ExerciseCatalog\Application\UseCases\GetExerciseCatalogDetailsUseCase;
use App\Modules\ExerciseCatalog\Application\UseCases\UpdateExerciseCatalogUseCase;
use App\Modules\WorkoutCategory\Application\UseCases\GetUserWorkoutCategoriesUseCase;
use Exception;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

final class Update extends Component
{
    use Toastable;

    public array $exerciseCatalog;

    public array $workoutCategories = [];

    protected array $rules = [
        'exerciseCatalog.id' => 'required|numeric',
        'exerciseCatalog.name' => 'required|string|max:255',
        'exerciseCatalog.workout_category_id' => 'required|numeric',
    ];

    public function render()
    {
        return view('exercise-catalog::livewire.update', [
            'workouts' => auth()->user()->exerciseCatalogs,
        ]);
    }

    public function mount(int $id, GetUserWorkoutCategoriesUseCase $getWorkoutsUseCase, GetExerciseCatalogDetailsUseCase $useCase): void
    {
        $userId = auth()->id();

        $getWorkoutsCommand = new GetUserWorkoutsCommand($userId);
        $this->workoutCategories = $getWorkoutsUseCase
            ->handle($getWorkoutsCommand)
            ->toArray();

        $getExerciseCommand = new GetExerciseCatalogDetailsCommand($id, $userId);
        $exerciseResult = $useCase->handle($getExerciseCommand);

        $this->exerciseCatalog = [
            'id' => $exerciseResult->id,
            'name' => $exerciseResult->name,
            'workout_category_id' => $exerciseResult->workoutCategoryId,
        ];
    }

    public function update(UpdateExerciseCatalogUseCase $useCase): void
    {
        $this->validate();

        try {
            $command = new UpdateExerciseCatalogCommand(
                id: $this->exerciseCatalog['id'],
                name: $this->exerciseCatalog['name'],
                workoutCategoryId: (int) $this->exerciseCatalog['workout_category_id'],
                userId: auth()->id(),
            );

            $useCase->handle($command);

            redirect(route('exercise-catalog'))->success(
                'Entrenamiento actualizado correctamente'
            );
        } catch (Exception $e) {
            $this->error('Error al crear el entrenamiento', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
