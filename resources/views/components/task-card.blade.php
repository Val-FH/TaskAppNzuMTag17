@props(['task'])

<article class="card mb-4 bg-base-100 shadow-sm transition hover:shadow-md">
    <div class="card-body">
        <div class="flex items-start justify-between gap-4">
            <div>
                <a href="/tasks/{{ $task->id }}"
                class="text-lg font-semibold hover:text-primary">
                    {{ $task->title }}
                </a>
                <p class="text-sm opacity-70">
                    von {{ $task->user?->name ?? 'der Klasse' }} {{ $task->done ? 'erledigt' : 'in Bearbeitung' }} {{ $task->updated_at->diffForHumans() }}
                </p>
            </div>
            <span class="badge {{ $task->done ? 'badge-success' : 'badge-ghost' }} font-bold">
                {{ $task->done ? 'Abgeschlossen' : 'Offen' }}
            </span>
        </div>

        <p class="mt-1">{{ $task->description }}</p>
                         <!-- mit unserer users() funktion aus dem task model ziehen wir die passenden user 
                            namen zum task uns aus der db und zeigen sie als string an dank implode -->
        <p class="mt-1"> {{ $task->users()->pluck('name')->implode(', ') }}    </p>  

    </div>
</article>