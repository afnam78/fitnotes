<?php

declare(strict_types=1);

namespace App\Modules\Exercise\Presentation\Livewire;

use App\Modules\Exercise\Application\Commands\CreateExerciseCommand;
use App\Modules\Exercise\Application\Commands\GetUserWorkoutsCommand;
use App\Modules\Exercise\Application\UseCases\CreateExerciseUseCase;
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
        } catch (Exception $e) {
            $this->error('Error al crear el ejercicio', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
