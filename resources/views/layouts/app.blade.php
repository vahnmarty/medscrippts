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

    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
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

    <div class="flex">
        
        @include('includes.partials.sidebar')

        <aside x-data="{ showSidebar: true }" 
            x-on:toggle-window.window="showSidebar = !showSidebar"
            x-init="$refs.main.classList.remove('w-72')"
            class="flex flex-1">


            @if(request()->is('scripts*'))
            <div class="lg:block hidden fixed top-[75px] z-20 transition-all duration-200 ease-in-out left-[50px]" 
                x-transition.duration.800ms>
                <button x-on:click="showSidebar = !showSidebar" type="button" class="p-1 rounded-full bg-darkgreen">
                    <x-heroicon-s-chevron-double-left x-show="showSidebar" class="w-4 h-4 text-gray-200 hover:text-white"/>
                    <x-heroicon-s-chevron-double-right x-show="!showSidebar" x-cloak class="w-4 h-4 text-gray-200 hover:text-white"/>
                </button>
            </div>
            
            <div
                :class="showSidebar ? 'w-72' : 'w-0'"
                x-ref="main"
                class="flex-shrink-0 hidden transition-all duration-300 ease-in-out border-r lg:block w-72">
                @livewire('script-settings')
            </div>
            @endif

            <div class="flex-1">
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
        </aside>

    </div>

    @include('includes.footer-nav')


    @stack('scripts')
    


    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />


</body>
</html>
