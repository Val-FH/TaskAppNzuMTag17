<x-layout title="Dashboard">

    <div class="flex items-center justify-between">
        <div>
            <h1> Hi, {{ $user->name }}!</h1>
    {{-- @dd(request()->user()); --}}
            <p> Deine Aufgaben </p>
        </div>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
            Neue Aufgabe
        </a>
    </div>

    <div class="card mt-6 bg-base-100 shadow-sm">
        <ul class="divide-y divide-base-200">
            @forelse($tasks as $task)
                <li class="flex items-center gap-4 px-5 py-4">
                    <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" title="{{ $task->done ? 'Wieder öffnen' : 'Als erledigt markieren' }}"
                            class="checkbox {{ $task->done ? 'checkbox-success' : '' }}"
                            {{ $task->done ? 'checked' : '' }}>
                            ✓
                        </button>
                    </form>

                    <a href="{{ route('tasks.show', $task) }}" 
                        class="flex-1 {{ $task->done ? 'opacity-50 line-through' : 'font-medium hover:text-primary' }}">
                        {{ $task->title }}
                    </a>

                    <span class="badge badge-sm {{ $task->done ? 'badge-success' : 'badge-ghost' }}">
                        {{ $task->done ? 'Abgeschlossen' : 'Offen' }}
                    </span>

                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-ghost btn-xs"> Bearbeiten </a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                        onsubmit="return confirm('Wirklich löschen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-ghost btn-xs text-error">Löschen</button>
                    </form>
                </li>
                @empty
                <li class="px-5 py-10 text-center opacity-60">
                    Noch keine Aufgaben
                </li>
                @endforelse
        </ul>
    </div>
</x-layout>