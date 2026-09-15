<x-layout title="Log in">

    <div class="mx-auto max-w-md">
        <h1> Wilkommen zurück </h1>


        <form action="{{ route('login') }}" method="POST">
            @csrf

            <fieldset class="fieldset">
                <legend>E-Mail</legend>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    class="input w-full {{ $errors->has('email') ? 'input-error' : '' }}">
                      <x-error name="email" /> 
            </fieldset>

            <fieldset class="fieldset">
                <legend>Passwort</legend>
                <input id="password" type="password" name="password"
                    class="input w-full {{ $errors->has('passowrd') ? 'input-error' : '' }}">
                       <x-error name="password" /> 
            </fieldset>

            <button type="submit" class="btn btn-soft btn-accent">
                Einloggen
            </button>
        </form>
    </div>
</x-layout>