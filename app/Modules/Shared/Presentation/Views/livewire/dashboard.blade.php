<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl  leading-tight">
            {{ __('¡Hola, '. auth()->user()->name . '!') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6  space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <x-card title="Entrenamientos Hoy" value="{{$workoutsToday}}" description="¡Sigue así!">
                            <div class="text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="lucide lucide-activity h-4 w-4 text-primary">
                                    <path
                                        d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2"></path>
                                </svg>
                            </div>
                        </x-card>
                        <x-card title="Series Esta Semana" value="{{$setsCurrentWeek}}" description="Entre lunes y domingo">
                            <div class="text-accent">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="lucide lucide-target h-4 w-4 text-secondary">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <circle cx="12" cy="12" r="6"></circle>
                                    <circle cx="12" cy="12" r="2"></circle>
                                </svg>
                            </div>
                        </x-card>
                        <x-card title="Volumen Semanal" value="{{$weeklyVolume}} Kg" description="Peso × repeticiones">
                            <div class="text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="lucide lucide-weight h-4 w-4 text-primary">
                                    <circle cx="12" cy="5" r="3"></circle>
                                    <path
                                        d="M6.5 8a2 2 0 0 0-1.905 1.46L2.1 18.5A2 2 0 0 0 4 21h16a2 2 0 0 0 1.925-2.54L19.4 9.5A2 2 0 0 0 17.48 8Z"></path>
                                </svg>
                            </div>
                        </x-card>
                    </div>
                    <div class="text-card-foreground flex flex-col gap-6 rounded-xl border py-6 shadow-sm bg-gradient-to-br from-primary/10 to-accent/10">
                        <div data-slot="card-content" class="p-6">
                            <div class="text-center space-y-2"><p
                                    class="text-sm font-medium italic">{{$motivationalMessage['sentence']}}</p>
                                <p class="text-xs">- {{$motivationalMessage['author']}}</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
