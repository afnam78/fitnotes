<?php

declare(strict_types=1);

namespace App\Modules\Workout\Presentation\Livewire;

use App\Modules\Workout\Application\Commands\GetWorkoutDetailsCommand;
use App\Modules\Workout\Application\Commands\UpdateWorkoutCommand;
use App\Modules\Workout\Application\UseCases\GetWorkoutDetailsUseCase;
use App\Modules\Workout\Application\UseCases\UpdateWorkoutUseCase;
use Exception;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

final class Update extends Component
{
    use Toastable;

    public int $workoutId;
    public string $name;
    public ?string $description = null;

    protected array $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
    ];

    public function render()
    {
        return view('workout::livewire.update');
    }

    public function mount(int $id, GetWorkoutDetailsUseCase $useCase): void
    {
        $this->workoutId = $id;

        $command = new GetWorkoutDetailsCommand($this->workoutId, auth()->id());
        $workout = $useCase->handle($command);

        $this->name = $workout->name;
        $this->description = $workout->description;
    }

    public function update(UpdateWorkoutUseCase $useCase): void
    {
        $this->validate();

        try {
            $command = new UpdateWorkoutCommand(
                workoutId: $this->workoutId,
                userId: auth()->id(),
                name: $this->name,
                description: $this->description,
            );

            $useCase->handle($command);


        } catch (Exception $e) {
            $this->error('Error al actualizar el entrenamiento');
        }
    }
}
