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