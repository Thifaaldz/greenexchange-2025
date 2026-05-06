<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Customer Dashboard' }}</title>

    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-white shadow p-4 flex justify-between">
        <h1 class="font-bold">Branch & QR System</h1>
        <a href="/logout" class="text-red-500">Logout</a>
    </nav>

    <main class="p-6">
        {{ $slot }}
    </main>

    @livewireScripts
    @stack('scripts')
</body>
</html>
