<nav>
    @auth
        <a
            href="{{ url('/dashboard') }}"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]"
        >
            Dashboard
        </a>
    @else
        <x-secondary-anchor href="{{ route('login') }}">
            Iniciar sesión
        </x-secondary-anchor>

        @if (Route::has('register'))
            <x-anchor href="{{ route('register') }}">
                Crear cuenta
            </x-anchor>
        @endif
    @endauth
</nav>
