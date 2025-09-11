<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl  leading-tight">
                {{ __('¡Hola, '. auth()->user()->name . '!') }}
            </h2>
            <x-anchor href="{{route('backup.import')}}">
                Backup Import
            </x-anchor>
        </div>
    </x-slot>
    <div>

        <div class="space-y-5">
            @if( auth()->user()->workouts->isEmpty() || auth()->user()->exercises->isEmpty())

                @php
                $route = auth()->user()->workouts->isEmpty() ? route('workout.create') : route('exercise.create');
                $message = auth()->user()->workouts->isEmpty() ? 'Crea tu primer entrenamiento' : 'Crea tu primer ejercicio';
                @endphp

                <a href="{{$route}}">
                    <x-card title="Primeros pasos" description="{{$message}}">
                        <div class="text-primary">
                            <x-click></x-click>
                        </div>
                    </x-card>
                </a>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <x-card title="Entrenamientos Hoy" value="{{$workoutsToday}}" description="¡Sigue así!">
                    <div class="text-primary">
                        <x-hearthbeat></x-hearthbeat>
                    </div>
                </x-card>
                <x-card title="Series Esta Semana" value="{{$setsCurrentWeek}}"
                        description="Entre lunes y domingo">
                    <div class="text-accent">
                        <x-dartboard></x-dartboard>
                    </div>
                </x-card>
                <x-card title="Volumen Semanal" value="{{$weeklyVolume}} Kg"
                        description="Peso × repeticiones">
                    <div class="text-primary">
                        <x-weight></x-weight>
                    </div>
                </x-card>
            </div>
            <div
                class="text-card-foreground flex flex-col gap-6 rounded-xl border py-6 shadow-sm bg-gradient-to-br from-primary/10 to-accent/10">
                <div data-slot="card-content" class="p-6">
                    <div class="text-center space-y-2"><p
                            class="text-sm font-medium italic">{{$motivationalMessage['sentence']}}</p>
                        <p class="text-xs">- {{$motivationalMessage['author']}}</p></div>
                </div>
            </div>
        </div>
    </div>
</div>
