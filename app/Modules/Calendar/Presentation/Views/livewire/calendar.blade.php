@php @endphp
<div>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl  leading-tight">
                {{ __('Calendario') }}
            </h2>
        </div>
    </x-slot>
    <div id="calendar" wire:ignore>
    </div>
    <x-modal name="showCalendarModal" size="md" :show="$errors->isNotEmpty()" focusable>
        <section class="p-4">
            <div class="flex justify-between items-center">
                <div class="font-semibold">
                    @if($selectedDate)
                        {{str($selectedDate->isoFormat('dddd D [de] MMMM [de] YYYY'))->upper()->value()}}
                    @endif
                </div>
                <button x-on:click="$dispatch('close')">
                    <x-x-mark></x-x-mark>
                </button>
            </div>
            <div class="mt-6 space-y-2">
                <div>
                    <label class="block mb-2 text-sm font-medium">Tipo de entrenamiento:</label>
                    <div class="grid grid-cols-3 gap-1">
                        @foreach($this->workouts as $workout)
                            @if(data_get($selectedWorkout, 'id') === $workout['id'])
                                <x-primary-button
                                    wire:click="workoutToSet({{ $workout['id'] }})">
                                    {{ $workout['name'] }}
                                </x-primary-button>
                            @else
                                <x-secondary-button
                                    wire:click="workoutToSet({{ $workout['id'] }})">
                                    {{ $workout['name'] }}
                                </x-secondary-button>
                            @endif
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('selectedWorkout.id')" class="mt-2"/>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium">Ejercicio:</label>
                    <div class="grid grid-cols-3 gap-1">
                        @foreach($workoutExercises as $exercise)
                            @if(data_get($selectedExercise, 'id') === $exercise['id'])
                                <x-primary-button wire:click="exerciseToSet({{ $exercise['id'] }})">
                                    {{ $exercise['name'] }}
                                </x-primary-button>
                            @else
                                <x-secondary-button wire:click="exerciseToSet({{ $exercise['id'] }})">
                                    {{ $exercise['name'] }}
                                </x-secondary-button>
                            @endif
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('selectedExercise.id')" class="mt-2"/>
                </div>
                <div class="flex items-center flex-col w-full mt-4">
                    <section class="grid gap-2 w-full">
                        <div class="w-full">
                            <x-input-label for="weight" value="{{ __('Peso') }}"/>
                            <x-text-input
                                wire:model="weight"
                                id="weight"
                                name="weight"
                                type="number"
                                class="block w-full"
                                placeholder="{{ __('KG') }}"
                            />
                            <x-input-error :messages="$errors->get('weight')" class="mt-2"/>
                        </div>
                        <div class="w-full">
                            <x-input-label for="reps" value="{{ __('Repeticiones') }}"/>
                            <x-text-input
                                wire:model="reps"
                                id="reps"
                                name="reps"
                                type="number"
                                class="block w-full"
                                placeholder="{{ __('Repeticiones') }}"
                            />
                            <x-input-error :messages="$errors->get('reps')" class="mt-2"/>
                        </div>
                        <x-primary-button wire:click="addSerie" class="text-xl ">Guardar</x-primary-button>
                    </section>
                </div>
            </div>
            @includeWhen(!empty($workoutsInSelectedDate), 'calendar::partials.workouts')
        </section>
    </x-modal>
</div>
@script
<script type="text/javascript">
    document.addEventListener('livewire:initialized', function () {
        let events = @this.events;

        let calendarEl = document.getElementById('calendar');
        let calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, interactionPlugin],
            initialView: 'dayGridMonth',
            editable: false,
            selectable: false,
            locale: 'es',
            firstDay: 1,
            events: events,
            height: 'auto',
            titleFormat: {
                year: 'numeric',
                month: 'short',
            },
            buttonText: {
                today: 'Hoy'
            },
            showNonCurrentDates: false,
            dateClick: function (event) {
                $wire.dispatchSelf('openCalendarModal', {date: event.dateStr});
            },
            eventClick: function (info) {
                info.jsEvent.preventDefault();

                $wire.dispatchSelf('openCalendarModal', {date: info.event.startStr});
            },
        });

        calendar.render();

        $wire.on('workoutUpdated', () => {
            let events = @this.events;

            calendar.removeAllEvents();
            calendar.addEventSource(events);
            calendar.render();
        });

    });
</script>
@endscript
