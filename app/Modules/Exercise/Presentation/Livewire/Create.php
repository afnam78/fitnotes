<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Presentation\Livewire;

use App\Modules\Exercise\Application\Commands\CreateExerciseCommand;
use App\Modules\Exercise\Application\Commands\GetUserWorkoutsCommand;
use App\Modules\Exercise\Application\UseCases\CreateExerciseUseCase;
use App\Modules\Exercise\Domain\Exceptions\ExerciseAlreadyExists;
use App\Modules\Workout\Application\UseCases\GetUserWorkoutsUseCase;
use Exception;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

final class Create extends Component
{
    use Toastable;

    public ?string $name = null;
    public ?string $description = null;
    public ?int $workout_id = null;
    public array $workouts = [];

    protected array $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'workout_id' => 'required|exists:workouts,id',
    ];

    public function render()
    {
        return view('exercise::livewire.create');
    }

    public function mount(GetUserWorkoutsUseCase $useCase): void
    {
        $command = new GetUserWorkoutsCommand(auth()->id());

        $workouts = $useCase->handle($command);

        $this->workouts = $workouts->toArray();
    }

    public function create(CreateExerciseUseCase $useCase): void
    {

        $this->validate();

        try {
            $command = new CreateExerciseCommand(
                name: $this->name,
                workoutId: $this->workout_id,
                userId: auth()->id(),
                description: $this->description,
            );

            $useCase->handle($command);

            redirect(route('exercise'))->success(
                'Ejercicio creado correctamente'
            );
        } catch (ExerciseAlreadyExists $e) {
            $this->error('Ya existe un ejercicio con ese nombre');
        } catch (Exception $e) {
            $this->error('Error al crear el ejercicio', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser una cadena de texto',
            'name.max' => 'El nombre no debe exceder los 255 caracteres',
            'description.string' => 'La descripción debe ser una cadena de texto',
            'description.max' => 'La descripción no debe exceder los 1000 caracteres',
            'workout_id.required' => 'Debes seleccionar un entrenamiento',
            'workout_id.exists' => 'El entrenamiento no existe',
        ];
    }
}
