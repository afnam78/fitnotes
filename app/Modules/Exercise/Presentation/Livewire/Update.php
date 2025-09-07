<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Presentation\Livewire;

use App\Modules\Exercise\Application\Commands\GetExerciseDetailsCommand;
use App\Modules\Exercise\Application\Commands\GetUserWorkoutsCommand;
use App\Modules\Exercise\Application\UseCases\GetExerciseDetailsUseCase;
use App\Modules\Workout\Application\UseCases\GetUserWorkoutsUseCase;
use Exception;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

final class Update extends Component
{
    use Toastable;

    public array $exercise;

    public array $workouts = [];


    protected array $rules = [
        'exercise.id' => 'required|exists:exercises,id',
        'exercise.name' => 'required|string|max:255',
        'exercise.description' => 'nullable|string|max:1000',
        'exercise.workout_id' => 'required|exists:workouts,id',
    ];

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

    public function create(): void
    {

        try {
            $this->validate();
            $this->service->create($this->exercise);

            redirect(route('exercise'))->success(
                'Entrenamiento creado correctamente'
            );
        } catch (Exception $e) {
            $this->error('Error al crear el entrenamiento', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
