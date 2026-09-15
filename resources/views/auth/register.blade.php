<x-layout title="Registrierung">

    <div class="mx-auto max-w-md">
        <h1> Account erstellen </h1>

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <fieldset class="fieldset">
                <legend>Name</legend>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                    class="input w-full {{ $errors->has('name') ? 'input-error' : '' }}">
                <x-error name="name" />
            </fieldset>

            <fieldset class="fieldset">
                <legend>E-Mail</legend>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    class="input w-full {{ $errors->has('email') ? 'input-error' : '' }}">
                <x-error name="email" />
            </fieldset>

            <fieldset class="fieldset">
                <legend>Passwort</legend>
                <input id="password" type="password" name="password"
                    class="input w-full {{ $errors->has('password') ? 'input-error' : '' }}">
               <x-error name="password" />
            </fieldset>

            <fieldset class="fieldset">
                <legend>Passwort bestätigen</legend>
            <input id="password_confirmation" type="password" name="password_confirmation"
                class="input w-full">
            </fieldset>

            <button type="submit" class="btn btn-primary w-full">
                Registrieren
            </button>
        </form>
    </div>    
</x-layout>