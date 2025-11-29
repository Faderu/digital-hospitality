<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'RS Sehat Sejahtera') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative bg-gray-900">
            
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/hospital-bg.jpg') }}" alt="Hospital Background" class="w-full h-full object-cover opacity-40">
                <div class="absolute inset-0 bg-teal-900 opacity-60"></div> </div>

            <div class="z-10 mb-6 text-center">
                <a href="/" class="flex flex-col items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo RS" class="w-24 h-24 object-contain drop-shadow-lg mb-2">
                    <h1 class="text-3xl font-bold text-white tracking-wide">DIGITALISASI RS</h1>
                    <p class="text-teal-100 text-sm">Sistem Informasi Manajemen Rumah Sakit Terpadu</p>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white/95 backdrop-blur-sm shadow-2xl overflow-hidden sm:rounded-2xl z-10 border-t-4 border-teal-500">
                @yield('content')
            </div>

            <div class="z-10 mt-8 text-teal-100 text-xs">
                &copy; {{ date('Y') }} Rumah Sakit Digital. All rights reserved.
            </div>
        </div>
    </body>
</html>