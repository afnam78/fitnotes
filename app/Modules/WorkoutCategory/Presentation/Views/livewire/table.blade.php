<div>
    <x-slot name="header">
    <div class="flex justify-between">
        <h2 class="font-semibold text-xl  leading-tight">
            {{ __('Tipo de entrenamientos') }}
        </h2>
        <x-anchor href="{{route('workout-category.create')}}">
            {{ __('Crear') }}
        </x-anchor>
    </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 w-12">
                                    Acciones
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nombre
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($workouts as $item)
                                <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                                    <th scope="row" class="px-6 py-4 font-medium  whitespace-nowrap">
                                        <a href="{{route('workout-category.update', $item->id)}}" class="font-medium text-blue-600 hover:underline">Editar</a>
                                        <x-danger-button wire:confirm="¿Estás seguro de realizar esta acción?" wire:click="delete({{$item->id}})" class="ml-2">
                                            {{ __('Eliminar') }}
                                        </x-danger-button>
                                    </th>
                                    <td class="px-6 py-4">
                                        {{$item->name}}
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
