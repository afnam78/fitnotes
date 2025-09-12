<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-geist">
    <section class="relative h-screen w-full">
        <img src="{{asset('powerlifting.png')}}" alt="powerlifting" class="absolute object-cover inset-0 w-full h-full bg-black/60">
        <div class="absolute inset-0 bg-gradient-to-b from-black/70 to-primary/10"></div>
        <div class="fixed top-0 w-full h-16 z-20 bg-white">
            <div class="max-w-7xl mx-auto p-4">
            <div class="flex justify-between items-center h-full">
                <div class="shrink-0 flex items-center gap-2">
                    <x-logo></x-logo>
                    <span class="text-xl font-bold">FitNotes</span>
                </div>
                <x-anchor href="{{route('register')}}">
                    ¡Empieza Ahora!
                </x-anchor>
            </div>
            </div>
        </div>
        <div class="relative z-10 flex items-center justify-center h-full text-center">

          <div class="p-4 space-y-4">
              <h1 class="text-2xl font-semibold text-white">
                  Tu Entrenamiento. Tu Progreso.
              </h1>
              <h2 class="text-white">
                  Organiza tus rutinas y alcanza tus metas.
              </h2>
              <x-anchor href="{{route('register')}}">
                  ¡Empieza Hoy!
              </x-anchor>
          </div>
        </div>
    </section>
    </body>
</html>
