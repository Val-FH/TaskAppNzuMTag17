@props(['title' => 'TaskApp'])

<!DOCTYPE html>
<html lang="de" data-theme="valentine">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - TaskApp</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-200 text-base-content antialiased">
    <x-nav />
    @auth
        <div class="list bg-base-100 rounded-box shadow-md">
           <h2>Benachrichtigungen: </h2>
           <ul class="list-disc">
            <!-- Wir lesen unsere nicht gelesenden notifications und schauen ob sie mehr als 0 sind-->
          @if(auth()->user()->unreadNotifications->count() > 0)
            <!-- wenn es ungelesene notifications gibt lassen wir uns die einzelnen arrays ausgeben-->
            @foreach(auth()->user()->unreadNotifications as $notification)
               
                     <!-- unsere aufgaben werden als liste und als link zur aufgabe ausgegeben-->
                     <li>
                    <a href="{{$notification->data['url'] }}" class="underline hover:no-underline">
                    {{$notification->data['message']}}  - {{$notification->data['title']}}</a>
                     <!-- link zum gelesne habn-->
                     <a href="/notifications/{{ $notification->id }}" class="underline text-red-800 ml-5">
                         Gelesen</a>
                    </li>
                
            @endforeach
           </ul>
          @else
            <p>Keine Benachrichtigungen!</p>
          @endif
        </div>
    @endauth
    <main class="mx-auto max-w-5xl px-4 py-8">
     @if(session('success'))
            <div class="alert alert-success mb-6">
                {{ session('success') }}
            </div>
        @endif
        {{ $slot }}
    </main>

</body>
</html>