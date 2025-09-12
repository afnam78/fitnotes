<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl  leading-tight">
            {{ __('Actualizar ejercicio') }}
        </h2>
    </x-slot>

    <form wire:submit="create">
        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
            <div class="sm:col-span-1">
                <label for="name" class="block mb-2 text-sm font-medium">Nombre</label>
                <input type="text" wire:model="exercise.name" id="name" class="bg-gray-50 border border-gray-300  text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " placeholder="Exercise name">
                <x-input-error :messages="$errors->get('exercise.name')" class="mt-2"/>
            </div>
            <div class="sm:col-span-1">
                <label for="workouts" class="block mb-2 text-sm font-medium">Entrenamientos</label>
                <select id="workouts" wire:model="exercise.workout_id" class="bg-gray-50 border border-gray-300  text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 ">
                    <option selected="">Selecciona</option>
                    @foreach ($workouts as $workout)
                        <option value="{{ $workout['id'] }}">{{ $workout['name'] }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('exercise.workout_id')" class="mt-2"/>
            </div>
            <div class="sm:col-span-2">
                <label for="description" class="block mb-2 text-sm font-medium">Description</label>
                <textarea id="description" wire:model="exercise.description" rows="8" class="block p-2.5 w-full text-sm  bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 " placeholder="Your description here"></textarea>
                <x-input-error :messages="$errors->get('exercise.description')" class="mt-2"/>
            </div>
        </div>
        <div class="flex justify-between mt-4">
            <x-secondary-anchor href="{{route('exercise')}}">
                {{ __('Volver') }}
            </x-secondary-anchor>
            <x-primary-button>
                {{ __('Actualizar') }}
            </x-primary-button>
        </div>
    </form>
</div>
