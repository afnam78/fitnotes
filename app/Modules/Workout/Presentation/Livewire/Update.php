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

            redirect(route('workout'))->success(
                'Entrenamiento actualizado correctamente',
            );
        } catch (Exception $e) {
            $this->error('Error al actualizar el entrenamiento');
        }
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'name.string' => 'El nombre debe ser una cadena de texto',
            'name.max' => 'El nombre no debe exceder los 255 caracteres',
            'description.string' => 'La descripción debe ser una cadena de texto',
            'description.max' => 'La descripción no debe exceder los 1000 caracteres',
        ];
    }
}
