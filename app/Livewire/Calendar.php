<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Exercise;
use App\Models\Set;
use App\Models\Workout;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

final class Calendar extends Component
{
    public ?Carbon $selectedDate = null;
    public ?Workout $selectedWorkout = null;
    public ?Exercise $selectedExercise = null;
    public array $workoutsInSelectedDate = [];
    public int $reps = 0;
    public float $weight = 0.0;
    public int $step = 0;
    public array $workoutsGroupedByDate = [];

    public function render()
    {
        return view('livewire.calendar');
    }

    public function mount(): void
    {
        $this->workoutsGroupedByDate = Set::query()
            ->with('exercise.workout')
            ->distinct()
            ->get()
            ->map(fn (Set $item) => [
                'start' => $item->set_date,
                'title' => $item->exercise->workout->name,
                'id' => $item->id,
            ])
            ->unique(fn (array $item) => $item['start'] . $item['title'])
            ->values()
            ->toArray();

    }

    #[On('openCalendarModal')]
    public function openCalendarModal(string $date): void
    {
        $this->reset([
            'selectedDate',
            'selectedWorkout',
            'selectedExercise',
            'workoutsInSelectedDate',
            'reps',
            'weight',
            'step',
        ]);

        $this->selectedDate = Carbon::parse($date);

        $this->workoutsInSelectedDate = Set::with('exercise.workout')
            ->where('set_date', $this->selectedDate->format('Y-m-d'))
            ->get()
            ->groupBy('exercise.workout.name')
            ->map(fn ($setsByWorkout) => $setsByWorkout->groupBy('exercise.name'))
            ->toArray();

        $this->dispatch('open-modal', 'showCalendarModal');
    }

    public function workoutToSet(Workout $selectedWorkout): void
    {
        $this->selectedWorkout = $selectedWorkout;
        $this->step = 1;
    }

    public function exerciseToSet(Exercise $selectedExercise): void
    {
        $this->selectedExercise = $selectedExercise;
        $this->step = 2;
    }

    public function addSerie(): void
    {
        $max = $this->selectedExercise
            ->sets()
            ->where(fn ($query) => $query->where('set_date', $this->selectedDate->format('Y-m-d')))
            ->max('order');

        $this->selectedExercise->sets()->create([
            'reps' => $this->reps,
            'weight' => $this->weight,
            'set_date' => $this->selectedDate->format('Y-m-d'),
            'order' => null === $max ? 1 : $max + 1,
        ]);

        $this->workoutsInSelectedDate = Set::with('exercise.workout')
            ->where('set_date', $this->selectedDate->format('Y-m-d'))
            ->get()
            ->groupBy('exercise.workout.name')
            ->map(fn ($setsByWorkout) => $setsByWorkout->groupBy('exercise.name'))->toArray();

        $this->workoutsGroupedByDate = Set::query()
            ->with('exercise.workout')
            ->distinct()
            ->get()
            ->map(fn (Set $item) => [
                'start' => $item->set_date,
                'title' => $item->exercise->workout->name,
                'id' => $item->id,
            ])
            ->unique(fn (array $item) => $item['start'] . $item['title'])
            ->values()
            ->toArray();

        $this->reset([
            'selectedDate',
            'selectedWorkout',
            'selectedExercise',
            'workoutsInSelectedDate',
            'reps',
            'weight',
            'step',
        ]);

        $this->dispatch('workoutUpdated');
    }
}
