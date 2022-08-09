<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    @vite(['resources/css/app.css'])
    @livewireStyles
</head>
<body class="antialiased bg-blue-50">
    <div class="min-h-full p-8">
        <div class="rounded p-8 shadow-lg mx-auto max-w-5xl bg-white border border-gray-300">
            <div>
                test
            </div>
            @livewire('select-component')
    </div>
    @vite(['resources/js/app.js'])
    @livewireScripts
</body>
</html>
