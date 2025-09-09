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


    protected array $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
    ];

    public function render()
    {
        return view('workout::livewire.create');
    }

    public function create(CreateWorkoutUseCase $useCase): void
    {

        try {
            $this->validate();

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
}
