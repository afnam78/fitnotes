<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar ejercicio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form wire:submit="create">
                        <div class="grid gap-4 sm:grid-cols-3 sm:gap-6">
                            <div class="sm:col-span-1">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
                                <input type="date" wire:model="date" id="name"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('exercise.name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="sm:col-span-1">
                                <label for="workouts"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Entrenamientos</label>
                                <select id="workouts" wire:model.live="selectedWorkoutId"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option selected="">Selecciona</option>
                                    @foreach ($workouts as $workout)
                                        <option value="{{ $workout->id }}">{{ $workout->name }}</option>
                                    @endforeach
                                </select>
                                @error('selectedWorkout')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            @if(!empty($selectedWorkoutId))
                                <div class="sm:col-span-1">
                                    <label for="workouts"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Entrenamientos</label>
                                    <select id="workouts" wire:model.live="selectedWExercise"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        <option selected="">Selecciona</option>
                                        @foreach ($exercises as $exercise)
                                            <option value="{{ $exercise->id }}">{{ $exercise->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('selectedWorkout')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif
                        </div>
                        <x-primary-button class="mt-4">
                            {{ __('Crear') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
