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
                    <div class="text-lg mb-2 font-medium">
                        {!! nl2br($title) !!}
                    </div>
                    @if($step == 1)
                        <section>
                            <div class="space-y-2">
                                <div>
                                    <label for="exerciseDate"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha</label>
                                    <input type="date" wire:model="exerciseDate" id="exerciseDate"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    @error('exerciseDate')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label for="workouts"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Entrenamientos</label>
                                    <select id="workouts" wire:model="selectedWorkoutId"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        <option selected="">Selecciona</option>
                                        @foreach ($workouts as $workout)
                                            <option value="{{ $workout->id }}">{{ $workout->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('selectedWorkoutId')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <x-primary-button wire:click="nextStep" class="mt-4">
                                {{ __('Siguiente') }}
                            </x-primary-button>
                        </section>
                    @endif

                    @if($step == 2)
                        <section>
                            <div class="space-y-2">
                                <div>
                                    <label for="exercises"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ejercicios</label>
                                    <select id="exercises" wire:model="selectedExerciseId"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        <option selected="">Selecciona</option>
                                        @foreach ($exercises as $exercise)
                                            <option value="{{ $exercise->id }}">{{ $exercise->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('selectedExerciseId')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <x-primary-button wire:click="nextStep" class="mt-4">
                                {{ __('Siguiente') }}
                            </x-primary-button>
                        </section>
                    @endif

                    @if($step == 3)
                        <section>
                            <div class="grid grid-cols-6 w-full gap-2">
                                <div class="sm:col-span-1">
                                    <label for="reps"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Repeticiones</label>
                                    <input type="text" wire:model="reps" id="reps"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                           placeholder="Exercise name">
                                    @error('reps')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="weight"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Peso (Kg)</label>
                                    <input type="text" wire:model="weight" id="weight"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                           placeholder="Exercise name">
                                    @error('weight')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="rir"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">RIR</label>
                                    <input type="text" wire:model="rir" id="rir"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                           placeholder="Exercise name">
                                    @error('rir')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <x-primary-button wire:click="create" class="mt-4">
                                {{ __('Crear') }}
                            </x-primary-button>
                        </section>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
