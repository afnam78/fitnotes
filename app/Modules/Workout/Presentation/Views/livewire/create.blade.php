<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Crear entrenamiento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <section class="bg-white">
                            <form wire:submit="create">
                                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                                    <div class="sm:col-span-2">
                                        <label for="name" class="block mb-2 text-sm font-medium">Nombre</label>
                                        <input type="text" wire:model="name" id="name" class="bg-gray-50 border border-gray-300  text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Workout name">
                                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="description" class="block mb-2 text-sm font-medium">Description</label>
                                        <textarea id="description" wire:model="description" rows="8" class="block p-2.5 w-full text-sm  bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="Your description here"></textarea>
                                        <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                                    </div>
                                </div>
                                <div class="flex justify-between mt-4">
                                    <x-secondary-anchor href="{{route('workout')}}">
                                        {{ __('Volver') }}
                                    </x-secondary-anchor>
                                    <x-primary-button>
                                        {{ __('Crear') }}
                                    </x-primary-button>
                                </div>
                            </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
