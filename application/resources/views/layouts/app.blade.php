<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<div id="app">

    @include('partials.header')

    <main class="pt-25 pb-16 min-h-screen">
        @yield('content')
    </main>

    @include('partials.footer')

</div>

</body>
</html>
