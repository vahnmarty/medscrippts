<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>{{ config('app.name') }} | @yield('title', 'Home')</title>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge"> <!-- † -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="url" content="{{ url('/') }}">

    @include('includes.partials.favicon')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Styles -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    <style>
        html,body{
            font-family: 'Outfit', sans-serif;
        }
        [x-cloak]{
            display: none !important;
        }
    </style>

    @stack('head-scripts')
</head>
<body class="bg-gray-100">
    <x-banner />

    <div class="flex">

        @include('includes.partials.sidebar')

        @livewire('script-settings')

        <div class="flex-1 max-h-screen overflow-auto">
            @include('includes.partials.header')
            <div class="bg-white md:px-8">
                @yield('header')
                {{ $header ?? '' }}
            </div>

            <main class="flex-grow">
                <div class="bg-white">
                    @yield('content')
                    {{ $slot ?? '' }}
                </div>

                @include('includes.partials.footer')
            </main>
        </div>

    </div>


    @stack('scripts')
    


    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />


</body>
</html>
