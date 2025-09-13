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

   <div class="space-y-4">
       <div class="flex gap-2 justify-start">
           <div>
               <x-input-label for="search" :value="__('Buscar')" />
               <x-text-input id="search" wire:model.live.debounce.250ms="search" placeholder="Buscar..."/>
           </div>
           <div class="w-44">
               <x-input-label for="selected_workout_id" :value="__('Entrenamiento')" />
               <select id="selected_workout_id" wire:model.live="selectedWorkout" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                   <option value="">Seleccionar</option>

                   @foreach($workouts as $item)
                       <option value="{{$item['id']}}">{{$item['name']}}</option>
                   @endforeach
               </select>
           </div>
       </div>
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
                           <a href="{{route('exercise.update', $item->exercise_id)}}"
                              class="bg-yellow-500 text-white p-1 rounded-md">
                               <x-edit></x-edit>
                           </a>

                           <button class="bg-red-600 text-white p-1 rounded-md"
                                   wire:confirm="¿Estás seguro de realizar esta acción?"
                                   wire:click="delete({{$item->exercise_id}})">
                               <x-trash></x-trash>
                           </button>
                       </th>
                       <td class="px-6 py-4">
                       <div class="flex gap-1 items-center">
                           <button class="p-1 rounded-md @if($item->favourite) text-yellow-400 @endif "                                    wire:click="markAsFavourite({{$item->exercise_id}})">
                               <x-star></x-star>
                           </button>
                           <p>
                               {{$item->exercise_name}}
                           </p>
                       </div>
                       </td>
                       <td class="px-6 py-4">
                           {{$item->workout->name}}
                       </td>
                   </tr>
               @endforeach
               </tbody>
           </table>
       </div>
       <div>
           {{$exercises->links()}}
       </div>
   </div>
</div>
