@php use App\Modules\Workout\Infrastructure\Database\Models\Workout; @endphp
<div>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl  leading-tight">
                {{ __('Calendario') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <div id="calendar" wire:ignore>

                    </div>
                </div>
            </div>
        </div>

        <x-modal name="showCalendarModal" :show="$errors->isNotEmpty()" focusable>
            <div class="p-2 flex justify-end">
                <button x-on:click="$dispatch('close')">
                    {{ __('X') }}
                </button>
            </div>
            <section class="p-6">
                @if($selectedDate)
                    {{$selectedDate->isoFormat('dddd D [de] MMMM [de] YYYY')}}
                @endif
                <div class="mt-6">
                    @if($step == 0)
                        <label class="block mb-2 text-sm font-medium  dark:text-white">Selecciona un
                            entrenamiento</label>
                        @foreach($this->workouts as $workout)
                            <button wire:click="workoutToSet({{ $workout['id'] }})"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded m-1">
                                {{ $workout['name'] }}
                            </button>
                        @endforeach
                    @endif

                    @if($step == 1)
                        <h2 class="font-medium text-lg">
                            {{$selectedWorkout['name']}}
                        </h2>
                        @foreach($workoutExercises as $exercise)
                            <button wire:click="exerciseToSet({{ $exercise['id'] }})"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded m-1">
                                {{ $exercise['name'] }}
                            </button>
                        @endforeach
                    @endif

                    @if($step == 2)
                        <div class="flex items-center flex-col">
                            <h2 class="font-medium text-lg">
                                {{$selectedWorkout['name']}} - {{$selectedExercise['name']}}
                            </h2>
                            <section class="flex justify-start gap-2">
                                <div>
                                    <x-input-label for="weight" value="{{ __('Peso') }}" class="sr-only"/>
                                    <x-text-input
                                        wire:model="weight"
                                        id="weight"
                                        name="weight"
                                        type="number"
                                        class="block"
                                        placeholder="{{ __('KG') }}"
                                    />
                                    <x-input-error :messages="$errors->get('sets')" class="mt-2"/>
                                </div>
                                <div>
                                    <x-input-label for="reps" value="{{ __('Repeticiones') }}" class="sr-only"/>
                                    <x-text-input
                                        wire:model="reps"
                                        id="reps"
                                        name="reps"
                                        type="number"
                                        class="block"
                                        placeholder="{{ __('Repeticiones') }}"
                                    />
                                    <x-input-error :messages="$errors->get('reps')" class="mt-2"/>
                                </div>
                                <x-primary-button wire:click="addSerie" class="text-xl ">+</x-primary-button>
                            </section>
                        </div>
                    @endif

                    @if(!empty($workoutsInSelectedDate))
                        <div>
                            <ul class="list-disc">
                                @foreach($workoutsInSelectedDate as $workouts)
                                    <li>
                                        <h3 class="text-lg font-semibold">
                                            {{$workouts['name']}}
                                        </h3>
                                        <div>
                                            @foreach($workouts['exercises'] as $exercise)
                                                <div>
                                                    <span class="font-medium"> - {{$exercise['name']}}:</span>
                                                    <div class="list-decimal ml-2">
                                                        @foreach($exercise['sets'] as $serie)
                                                            <div>{{$serie['weight']}}kg x {{$serie['reps']}} reps</div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    @endif
                </div>
            </section>
        </x-modal>
    </div>
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
