<x-layout title="Welcome">

    <section class="mb-8 text-center">
        <h1 class="text-3xl font-bold"> Willkommen zur fantastischen TaskApp </h1>
            <p class="mt-2 opacity-70">
                Erstellen und Bearbeiten Sie Ihre Aufgaben!
                 <br>
                Bitte Loggen Sie sich ein oder registrieren sich.
            </p>

            <div class="mt-6 flex items-center justify-center gap-3">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
                    <a href="{{ route('register') }}" class="btn">Registrieren</a>
                @endguest
                @auth
                    <a href="{{ route('tasks.index') }}" class="btn btn-primary">Zu den Tasks</a>
                @endauth
            </div>
    </section>           
</x-layout>