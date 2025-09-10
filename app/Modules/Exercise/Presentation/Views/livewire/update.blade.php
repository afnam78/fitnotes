<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl  leading-tight">
            {{ __('Actualizar ejercicio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <section class="bg-white">
                            <form wire:submit="create">
                                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">

                                    <div class="sm:col-span-1">
                                        <label for="name" class="block mb-2 text-sm font-medium">Nombre</label>
                                        <input type="text" wire:model="exercise.name" id="name" class="bg-gray-50 border border-gray-300  text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " placeholder="Exercise name">
                                        @error('exercise.name')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="sm:col-span-1">
                                        <label for="workouts" class="block mb-2 text-sm font-medium">Entrenamientos</label>
                                        <select id="workouts" wire:model="exercise.workout_id" class="bg-gray-50 border border-gray-300  text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 ">
                                            <option selected="">Selecciona</option>
                                            @foreach ($workouts as $workout)
                                                <option value="{{ $workout['id'] }}">{{ $workout['name'] }}</option>
                                            @endforeach
x
                                        </select>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="description" class="block mb-2 text-sm font-medium">Description</label>
                                        <textarea id="description" wire:model="exercise.description" rows="8" class="block p-2.5 w-full text-sm  bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 " placeholder="Your description here"></textarea>
                                        @error('exercise.description')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <x-primary-button class="mt-4">
                                    {{ __('Actualizar') }}
                                </x-primary-button>
                            </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
