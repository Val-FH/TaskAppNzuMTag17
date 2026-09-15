@props([
    'route',
    'placeholder' => 'Aufgaben durchsuchen',
])

<form action="{{ route($route) }}" method="GET" class="mt-6 flex gap-2">
    <input type="text" name="q" value="{{ request('q') }}"
        placeholder="{{ $placeholder }}" class="input w-full max-w-md">
         @if(request('status'))
        {{-- hidden -> unsichtbar aber wird wie jedes andere feld mitgeschickt --}}
        <input type="hidden" name="status" value="{{ request('status') }}">
    @endif
    <button type="submit" class="btn btn-primary">Suchen</button>
    <a href="{{ route($route) }}" class="btn shrink-0">Alle Anzeigen</a>
</form>
