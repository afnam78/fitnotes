<div>
    <x-slot name="header">
    <div class="flex justify-between">
        <h2 class="font-semibold text-xl  leading-tight">
            {{ __('Ejercicios') }}
        </h2>
        <x-anchor href="{{route('exercise.create')}}">
            {{ __('Crear') }}
        </x-anchor>
    </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 w-12">
                                    Acciones
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nombre
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Entrenamiento
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($exercises as $item)
                                <tr class="odd:bg-white even:bg-gray-50 border-gray-200">
                                    <th scope="row" class="px-6 py-4 font-medium flex gap-1 items-center whitespace-nowrap">
                                        <a href="{{route('exercise.update', $item->id)}}" class="bg-yellow-500 text-white p-1 rounded-md">
                                            <x-edit></x-edit>
                                        </a>

                                        <button class="bg-red-600 text-white p-1 rounded-md" wire:confirm="¿Estás seguro de realizar esta acción?" wire:click="delete({{$item->id}})">
                                            <x-trash></x-trash>
                                        </button>
                                    </th>
                                    <td class="px-6 py-4">
                                        {{$item->name}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$item->workout->name}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
