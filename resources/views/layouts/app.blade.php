<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>@yield('title', 'Students Records')</title> --}}
    <title>
        @hasSection('title')
            @yield('title') | Students Records
        @else
            Students Records
        @endif
    </title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-dark">
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @yield('scripts')
</body>
</html>