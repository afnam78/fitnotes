@if(!empty($workoutsInSelectedDate))
    <div class="grid gap-2 md:grid-cols-2 border-t mt-5 pt-5">
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
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Peso (KG)
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Repeticiones
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($exercise['sets'] as $serie)
                                <tr class="bg-white border-b border-gray-200">
                                    <td class="px-6 py-4">
                                        {{$loop->iteration}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$serie['weight']}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$serie['reps']}}
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
