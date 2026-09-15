<x-layout title="Aufgabe bearbeiten">

    <div class="mx-auto max-w-xl">
        <h1> Neue Aufgabe! </h1>

        <form action="{{ route('tasks.update', $task) }}" method="POST"
            class="mt-6 space-y-4 rounded-box border border-base-300 bg-base-100 p-6 shadow-sm">
            @csrf
            @method('PUT')

            <fieldset class="fieldset">
                <legend>Titel</legend>
                <input id="title" type="text" name="title" value="{{ old('title', $task->title) }}"
                    class="input w-full {{ $errors->has('title') ? 'input-error' : '' }}">
                    <x-error name="title" />
            </fieldset>

            <fieldset class="fieldset">
                <legend>Beschreibung</legend>
                <textarea id="description" name="description" rows="4"
                    class="textarea w-full {{ $errors->has('description') ? 'textarea-error' : '' }}">{{ old('description', $task->description) }}</textarea>
              <x-error name="description" />
            </fieldset>
             <fieldset class='fieldset'>
                <legend>User hinzufügen (Strg + Klick)</legend>
                <select name="user[]" id="user" multiple class="">
                  @foreach ($users as $user )
                        <option value="{{ $user->id }}" >
                             {{$user->name }}</option>  <!-- geschwungende klammern weil blade-->
                    @endforeach
                </select>
                 <x-error name="user"/>
            </fieldset>
            @can('task-view')
            <button type="submit" class="btn btn-primary">Aufgabe ändern</button>
            @endcan
        </form>
    </div>
</x-layout>
     
     
     
    