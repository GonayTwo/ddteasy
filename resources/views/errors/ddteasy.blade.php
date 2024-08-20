<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>DDTeasy - @yield('code')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <livewire:web.components.navbar />
    <div class="grid px-4 py-52 md:py-52 bg-white place-content-center">
        <div class="text-center">
            <h1 class="font-black text-violet-900 text-9xl">@yield('code')</h1>

            <p class="text-2xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                Ops!
            </p>

            <p class="mt-4 text-gray-500">@yield('message')</p>

            <a href="{{ route('site.home') }}"
                class="inline-block px-5 py-3 mt-6 text-xl text-white font-bold bg-orange-ddteasy hover:bg-violet-900 transition-all ease-in-out">
                Ir para a home
            </a>
        </div>
    </div>
    <livewire:web.components.footer />
</body>

</html>