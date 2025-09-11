@if(!empty($workoutsInSelectedDate))
    <div class="grid gap-2 border-t mt-5 pt-5">
        @foreach($workoutsInSelectedDate as $workouts)
            <div class="border rounded md:col-span-1">
                <div class="font-medium border-b bg-gray-500 text-white p-2 text-center">
                    {{$workouts['name']}}
                </div>

                @foreach($workouts['exercises'] as $exercise)
                    <div class="font-medium border-b bg-gray-400 text-white p-2 text-center">
                        {{$exercise['name']}}
                    </div>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left table-fixed">
                            <thead class="text-xs uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="p-3 w-4">
                                    #
                                </th>
                                <th scope="col" class="p-3">
                                    Peso (KG)
                                </th>
                                <th scope="col" class="p-3">
                                    Reps
                                </th>
                                <th scope="col" class="p-3 text-center">
                                    Acciones
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($exercise['sets'] as $serie)
                                <tr x-data="{edit: false, weightToSet: '{{$serie['weight']}}', repsToSet: '{{$serie['reps']}}'}" class="bg-white border-b border-gray-200">
                                    <td class="p-3 font-medium">
                                        {{$loop->iteration}}
                                    </td>
                                    <td class="p-3">
                                        <span x-show="!edit">
                                        {{$serie['weight']}}
                                        </span>
                                        <input type="number" x-model="weightToSet" class="w-20 h-fit p-0" x-show="edit" placeholder="{{$serie['weight']}}"/>
                                    </td>
                                    <td class="p-3">
                                            <span x-show="!edit">
                                                {{$serie['reps']}}
                                        </span>
                                        <input type="number" x-model="repsToSet" class="w-20 h-fit p-0" x-show="edit" placeholder="{{$serie['reps']}}"/>
                                    </td>
                                    <td class="p-3 flex justify-center gap-1">
                                        <button x-show="!edit" @click="edit=true" class="bg-yellow-500 text-white rounded p-1">
                                            <x-edit></x-edit>
                                        </button>
                                        <button x-show="edit" @click="edit=false" class="bg-white text-dark rounded p-1 border border-dark">
                                            <x-x-mark></x-x-mark>
                                        </button>
                                        <button x-show="edit" @click="edit=false, $wire.updateSet({{$serie['id']}}, weightToSet, repsToSet)" class="bg-primary text-white rounded p-1">
                                            <x-check></x-check>
                                        </button>
                                        <button x-show="!edit" wire:click="deleteSet({{$serie['id']}})" class="bg-red-500 text-white rounded p-1">
                                            <x-trash></x-trash>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endif
