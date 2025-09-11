<?php

declare(strict_types=1);

namespace App\Modules\Workout\Presentation\Livewire;

use App\Modules\Workout\Application\Commands\CreateWorkoutCommand;
use App\Modules\Workout\Application\UseCases\CreateWorkoutUseCase;
use Exception;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

final class Create extends Component
{
    use Toastable;

    public ?string $name = null;
    public ?string $description = null;



    public function render()
    {
        return view('workout::livewire.create');
    }

    public function create(CreateWorkoutUseCase $useCase): void
    {

        $this->validate();

        try {
            $command = new CreateWorkoutCommand(
                name: $this->name,
                userId: auth()->id(),
                description: $this->description,
            );

            $useCase->handle($command);

            redirect(route('workout'))->success(
                'Entrenamiento creado correctamente',
            );
        } catch (Exception $e) {
            $this->error('Error al crear el entrenamiento');
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
