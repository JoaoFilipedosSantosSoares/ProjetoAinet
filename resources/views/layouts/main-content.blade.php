<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FunShirt</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#fbfaf7] min-h-screen flex flex-col antialiased">

    @include('layouts.app.header')

    <main class="flex-1">
        {{ $slot }}
    </main>

    @livewireScripts
    @fluxScripts
</body>
</html>