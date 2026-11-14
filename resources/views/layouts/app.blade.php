<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PT. Solusi Net Nusantara - solusi teknologi dan konektivitas bisnis.">
    <link rel="icon" type="image/png" href="{{ asset('images/lgmode.png') }}">
    <title>@yield('title', 'PT. Solusi Net Nusantara')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    @include('partials.header')
    <main>@yield('content')</main>
    @include('partials.footer')
</body>
</html>
