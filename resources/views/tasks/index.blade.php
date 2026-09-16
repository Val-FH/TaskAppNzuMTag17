<x-layout title="Index">
    <section class="mb-8 text-center">
        <h1 class="text-3xl font-bold"> Liste aller Aufgaben </h1>
        
        <x-search-form route="tasks.index" />
    </section>
    <div class="flex justify-center gap-2 mt-4">
       <a href="{{ route('tasks.index', ['q' => request('q')]) }}"
            class="btn btn-sm {{ request('status') ? 'btn-ghost' : 'btn-primary' }}">Alle</a>
      <a href="{{ route('tasks.index', ['status' => 'open', 'q' => request('q')]) }}" 
            class="btn btn-sm {{ request('status') === 'open' ? 'btn-primary' : 'btn-ghost' }}">Offen</a>
           <a href="{{ route('tasks.index', ['status' => 'done', 'q' => request('q')]) }}"
            class="btn btn-sm {{ request('status') === 'done' ? 'btn-primary' : 'btn-ghost' }}">Erledigt</a>
    </div>
    @forelse($tasks as $task)
        <x-task-card :task="$task" />
    @empty
        @if(request('q'))
            Keine Aufgaben gefunden für "{{ request('q') }}"
        @else
            Keine Aufgaben gefunden
        @endif
    @endforelse

    {{ $tasks->links() }}

</x-layout>