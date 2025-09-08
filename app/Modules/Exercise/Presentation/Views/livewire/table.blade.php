<div>
    <x-slot name="header">
    <div class="flex justify-between">
        <h2 class="font-semibold text-xl  leading-tight">
            {{ __('Ejercicios') }}
        </h2>

        <a href="{{route('exercise.create')}}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-600 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition ease-in-out duration-150">
            {{ __('Crear ejercicio') }}
        </a>
    </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                    <th scope="row" class="px-6 py-4 font-medium  whitespace-nowrap dark:text-white">
                                        <a href="{{route('exercise.update', $item->id)}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Editar</a>
                                        <x-danger-button wire:confirm="¿Estás seguro de realizar esta acción?" wire:click="delete({{$item->id}})" class="ml-2">
                                            {{ __('Eliminar') }}
                                        </x-danger-button>
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
