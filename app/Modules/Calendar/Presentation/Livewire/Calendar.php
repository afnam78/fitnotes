<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Presentation\Livewire;

use App\Modules\Calendar\Application\Commands\DeleteSetCommand;
use App\Modules\Calendar\Application\Commands\GetEventsCommand;
use App\Modules\Calendar\Application\Commands\GetRegistersByDateCommand;
use App\Modules\Calendar\Application\Commands\GetWorkoutWithRelatedExercisesCommand;
use App\Modules\Calendar\Application\Commands\UpdateSetCommand;
use App\Modules\Calendar\Application\UseCases\CreateSetUseCase;
use App\Modules\Calendar\Application\UseCases\DeleteSetUseCase;
use App\Modules\Calendar\Application\UseCases\GetEventsUseCase;
use App\Modules\Calendar\Application\UseCases\GetRegistersByDateUseCase;
use App\Modules\Calendar\Application\UseCases\GetWorkoutWithRelatedExercisesUseCase;
use App\Modules\Calendar\Application\UseCases\UpdateSetUseCase;
use App\Modules\Exercise\Application\Commands\GetUserWorkoutsCommand;
use App\Modules\Workout\Application\UseCases\GetUserWorkoutsUseCase;
use Exception;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Throwable;

final class Calendar extends Component
{
    use Toastable;

    public ?Carbon $selectedDate = null;
    public array $selectedWorkout = [];

    public array $workoutExercises = [];

    public array $selectedExercise = [];
    public array $workoutsInSelectedDate = [];
    public int $reps = 0;
    public float $weight = 0.0;
    public array $events = [];
    public array $workouts = [];
    public ?float $weightToSet = null;
    public ?int $repsToSet = null;
    public ?int $setIdToModify = null;

    public function render()
    {
        return view('calendar::livewire.calendar');
    }

    public function mount(GetEventsUseCase $getEventsUseCase, GetUserWorkoutsUseCase $getUserWorkoutsUseCase): void
    {
        $this->setEvents($getEventsUseCase);

        $command = new GetUserWorkoutsCommand(userId: auth()->id());
        $this->workouts = array_map(
            function (array $workout) {
                unset($workout['description']);
                return $workout;
            },
            $getUserWorkoutsUseCase->handle($command)->toArray()
        );
    }

    #[On('openCalendarModal')]
    public function openCalendarModal(string $date, GetRegistersByDateUseCase $useCase): void
    {
        try {
            $this->reset([
                'selectedDate',
                'selectedWorkout',
                'selectedExercise',
                'workoutsInSelectedDate',
                'reps',
                'weight',
            ]);

            $this->selectedDate = Carbon::parse($date);
            $this->setWorkoutsInSelectedDate($useCase);

            $this->dispatch('open-modal', 'showCalendarModal');
        } catch (Throwable $e) {
            $this->error('Error');
        }
    }

    public function workoutToSet(int $selectedWorkout, GetWorkoutWithRelatedExercisesUseCase $useCase): void
    {
        try {
            if (data_get($this->selectedWorkout, 'id') === $selectedWorkout) {
                return;
            }

            $this->reset([
                'selectedWorkout',
                'selectedExercise',
                'workoutExercises',
            ]);

            $command = new GetWorkoutWithRelatedExercisesCommand(
                workoutId: $selectedWorkout,
                userId: auth()->id(),
            );

            $result = $useCase->handle($command);

            $this->selectedWorkout = [
                'id' => $result->workoutId,
                'name' => $result->workoutName,
            ];

            $this->workoutExercises = $result->toArray()['exercises'];
        } catch (Throwable $e) {
            $this->error('Error');
        }
    }

    public function exerciseToSet(int $selectedExercise): void
    {
        try {
            $this->selectedExercise = $this->getExerciseToSet($selectedExercise);
        } catch (Throwable $e) {
            $this->error('Error');
        }
    }

    public function addSerie(CreateSetUseCase $createSetUseCase, GetEventsUseCase $getEventsUseCase, GetRegistersByDateUseCase $getRegistersByDateUseCase): void
    {

        $this->validate([
            'selectedExercise.id' => 'required|exists:exercises,id',
            'reps' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'selectedDate' => 'required|date',
            'selectedWorkout.id' => 'required|exists:workouts,id',
        ]);

        try {
            $createSetCommand = new \App\Modules\Calendar\Application\Commands\CreateSetCommand(
                exerciseId: $this->selectedExercise['id'],
                reps: $this->reps,
                weight: $this->weight,
                userId: auth()->id(),
                date: $this->selectedDate,
            );

            $createSetUseCase->handle($createSetCommand);

            $this->setWorkoutsInSelectedDate($getRegistersByDateUseCase);
            $this->setEvents($getEventsUseCase);

            $this->reset([
                'reps',
                'weight',
            ]);

            $this->dispatch('workoutUpdated', $this->events);
        } catch (Throwable $e) {
            $this->error('Error');
        }
    }

    public function updateSet(int $setId, float $weight, int $reps, UpdateSetUseCase $useCase, GetRegistersByDateUseCase $getRegistersByDateUseCase): void
    {
        $this->repsToSet = $reps;
        $this->weightToSet = $weight;

        $this->validate([
            'repsToSet' => 'required|numeric|min:0',
            'weightToSet' => 'required|numeric|min:0',
        ]);

        try {
            $updateSetCommand = new UpdateSetCommand(
                setId: $setId,
                userId: auth()->id(),
                reps: $this->repsToSet,
                weight: $this->weightToSet
            );

            $useCase->handle($updateSetCommand);

            $this->reset([
                'repsToSet',
                'weightToSet',
                'setIdToModify',
            ]);

            $this->setWorkoutsInSelectedDate($getRegistersByDateUseCase);

            $this->success('Serie actualizada correctamente');
        } catch (Exception $e) {
            $this->error('Error');
        }
    }

    public function deleteSet(int $setId, DeleteSetUseCase $useCase, GetRegistersByDateUseCase $getRegistersByDateUseCase, GetEventsUseCase $getEventsUseCase): void
    {

        try {
            $deleteSetCommand = new DeleteSetCommand(
                setId: $setId,
                userId: auth()->id(),
            );

            $useCase->handle($deleteSetCommand);

            $this->setWorkoutsInSelectedDate($getRegistersByDateUseCase);
            $this->setEvents($getEventsUseCase);

            $this->dispatch('workoutUpdated', $this->events);
            $this->success('Serie eliminada correctamente');
        } catch (Exception $e) {
            $this->error('Error');
        }
    }


    protected function messages(): array
    {
        return [
            'selectedExercise.id.required' => 'Debes seleccionar un ejercicio',
            'selectedExercise.id.exists' => 'El ejercicio seleccionado no es válido',
            'reps.required' => 'Debes ingresar las repeticiones',
            'reps.numeric' => 'Las repeticiones deben ser un número',
            'reps.min' => 'Las repeticiones deben ser un número positivo',
            'weight.required' => 'Debes ingresar el peso',
            'weight.numeric' => 'El peso debe ser un número',
            'weight.min' => 'El peso debe ser un número positivo',
            'selectedDate.required' => 'La fecha es obligatoria',
            'selectedDate.date' => 'La fecha no es válida',
            'selectedWorkout.id.required' => 'Debes seleccionar un entrenamiento',
            'selectedWorkout.id.exists' => 'El entrenamiento seleccionado no es válido',
            'repsToSet.required' => 'Debes ingresar las repeticiones',
            'repsToSet.numeric' => 'Las repeticiones deben ser un número',
            'repsToSet.min' => 'Las repeticiones deben ser un número positivo',
            'weightToSet.required' => 'Debes ingresar el peso',
            'weightToSet.numeric' => 'El peso debe ser un número',
            'weightToSet.min' => 'El peso debe ser un número positivo',
        ];
    }

    private function getExerciseToSet(int $selectedExercise): array
    {
        $item = array_filter($this->workoutExercises, fn (array $exercise) => $exercise['id'] === $selectedExercise);

        return data_get(array_values($item), 0, []);
    }

    private function setEvents(GetEventsUseCase $useCase): void
    {
        $command = new GetEventsCommand(userId: auth()->id());
        $result = $useCase->handle($command);

        $this->events = $result->toArray();
    }

    private function setWorkoutsInSelectedDate(GetRegistersByDateUseCase $useCase): void
    {
        $command = new GetRegistersByDateCommand(
            userId: auth()->id(),
            date: $this->selectedDate,
        );

        $this->workoutsInSelectedDate = $useCase->handle($command)->toArray();
    }
}
