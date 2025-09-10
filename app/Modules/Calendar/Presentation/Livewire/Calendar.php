<?php

declare(strict_types=1);

namespace App\Modules\Calendar\Presentation\Livewire;

use App\Modules\Calendar\Application\Commands\GetEventsCommand;
use App\Modules\Calendar\Application\Commands\GetRegistersByDateCommand;
use App\Modules\Calendar\Application\Commands\GetWorkoutWithRelatedExercisesCommand;
use App\Modules\Calendar\Application\UseCases\CreateSetUseCase;
use App\Modules\Calendar\Application\UseCases\GetEventsUseCase;
use App\Modules\Calendar\Application\UseCases\GetRegistersByDateUseCase;
use App\Modules\Calendar\Application\UseCases\GetWorkoutWithRelatedExercisesUseCase;
use App\Modules\ExerciseCatalog\Application\Commands\GetUserWorkoutsCommand;
use App\Modules\WorkoutCategory\Application\UseCases\GetUserWorkoutCategoriesUseCase;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Throwable;

final class Calendar extends Component
{
    use Toastable;

    public ?Carbon $selectedDate = null;
    public array $selectedWorkoutCategory = [];

    public array $workoutExerciseCategories = [];

    public array $selectedExerciseCatalog = [];
    public array $workoutsInSelectedDate = [];
    public int $reps = 0;
    public float $weight = 0.0;
    public array $events = [];
    public array $workouts = [];

    public function render()
    {
        return view('calendar::livewire.calendar');
    }

    public function mount(GetEventsUseCase $getEventsUseCase, GetUserWorkoutCategoriesUseCase $getUserWorkoutsUseCase): void
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
                'selectedWorkoutCategory',
                'selectedExerciseCatalog',
                'workoutsInSelectedDate',
                'workoutExerciseCategories',
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

    public function workoutCategoryToSet(int $selectedWorkout, GetWorkoutWithRelatedExercisesUseCase $useCase): void
    {
        try {
            $this->reset([
                'selectedExerciseCatalog',
            ]);

            $command = new GetWorkoutWithRelatedExercisesCommand(
                workoutId: $selectedWorkout,
                userId: auth()->id(),
            );

            $result = $useCase->handle($command);

            $this->selectedWorkoutCategory = [
                'id' => $result->workoutId,
                'name' => $result->workoutName,
            ];

            $this->workoutExerciseCategories = $result->toArray()['exercise_categories'] ?? [];

        } catch (Throwable $e) {
            $this->error('Error');
        }
    }

    public function exerciseToSet(int $selectedExercise): void
    {
        try {
            $this->selectedExerciseCatalog = $this->getExerciseToSet($selectedExercise);

        } catch (Throwable $e) {
            $this->error('Error');
        }
    }

    public function addSerie(CreateSetUseCase $createSetUseCase, GetEventsUseCase $getEventsUseCase, GetRegistersByDateUseCase $getRegistersByDateUseCase): void
    {
        try {
            $createSetCommand = new \App\Modules\Calendar\Application\Commands\CreateSetCommand(
                exerciseCatalogId: $this->selectedExerciseCatalog['id'],
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

    private function getExerciseToSet(int $selectedExercise): array
    {
        $item = array_filter($this->workoutExerciseCategories, fn (array $exercise) => $exercise['id'] === $selectedExercise);

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
