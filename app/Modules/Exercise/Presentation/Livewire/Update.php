<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Presentation\Livewire;

use App\Modules\Exercise\Application\Commands\GetExerciseDetailsCommand;
use App\Modules\Exercise\Application\Commands\GetUserWorkoutsCommand;
use App\Modules\Exercise\Application\Commands\UpdateExerciseCommand;
use App\Modules\Exercise\Application\UseCases\GetExerciseDetailsUseCase;
use App\Modules\Exercise\Application\UseCases\UpdateExerciseUseCase;
use App\Modules\Workout\Application\UseCases\GetUserWorkoutsUseCase;
use Exception;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

final class Update extends Component
{
    use Toastable;

    public array $exercise;

    public array $workouts = [];

    public function render()
    {
        return view('exercise::livewire.update', [
            'workouts' => auth()->user()->workouts,
        ]);
    }

    public function mount(int $id, GetUserWorkoutsUseCase $getWorkoutsUseCase, GetExerciseDetailsUseCase $useCase): void
    {
        $userId = auth()->id();

        $getWorkoutsCommand = new GetUserWorkoutsCommand($userId);
        $this->workouts = $getWorkoutsUseCase
            ->handle($getWorkoutsCommand)
            ->toArray();

        $getExerciseCommand = new GetExerciseDetailsCommand($id, $userId);
        $exerciseResult = $useCase->handle($getExerciseCommand);

        $this->exercise = [
            'id' => $exerciseResult->id,
            'name' => $exerciseResult->name,
            'description' => $exerciseResult->description,
            'workout_id' => $exerciseResult->workoutId,
        ];
    }

    public function create(UpdateExerciseUseCase $useCase): void
    {
        $this->validate();

        try {
            $command = new UpdateExerciseCommand(
                id: $this->exercise['id'],
                name: $this->exercise['name'],
                description: $this->exercise['description'],
                workoutId: (int) $this->exercise['workout_id'],
                userId: auth()->id(),
            );

            $useCase->handle($command);

            redirect(route('exercise'))->success(
                'Entrenamiento actualizado correctamente'
            );
        } catch (Exception $e) {
            $this->error('Error al crear el entrenamiento', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    protected function rules(): array
    {
        return [
            'exercise.id' => 'required|numeric|exists:exercises,id',
            'exercise.name' => 'required|string|max:255',
            'exercise.description' => 'nullable|string|max:1000',
            'exercise.workout_id' => 'required|exists:workouts,id',
        ];
    }

    protected function messages(): array
    {
        return [
            'exercise.name.required' => 'El nombre es requerido',
            'exercise.name.string' => 'El nombre debe ser una cadena de texto',
            'exercise.name.max' => 'El nombre no debe exceder los 255 caracteres',
            'exercise.description.string' => 'La descripción debe ser una cadena de texto',
            'exercise.description.max' => 'La descripción no debe exceder los 1000 caracteres',
            'exercise.workout_id.required' => 'Debes seleccionar un entrenamiento',
            'exercise.workout_id.exists' => 'El entrenamiento no existe',
        ];
    }
}
