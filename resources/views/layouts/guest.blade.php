<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EasyColoc') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Outfit', sans-serif; }
            .gradient-bg { background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); }
            .gradient-text { background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        </style>
    </head>
    <body class="antialiased font-sans text-slate-900 bg-slate-50">
        <div class="min-h-screen flex flex-col items-center justify-center p-6 relative overflow-hidden">
            <!-- Background Orbs -->
            <div class="absolute top-[10%] left-[-10%] w-[40%] h-[40%] bg-indigo-200/30 blur-[120px] rounded-full -z-10"></div>
            <div class="absolute bottom-[10%] right-[-5%] w-[30%] h-[30%] bg-purple-200/30 blur-[100px] rounded-full -z-10"></div>

            <div class="mb-10 text-center">
                <a href="/" wire:navigate class="flex flex-col items-center gap-2 group">
                    <div class="w-16 h-16 gradient-bg rounded-2xl flex items-center justify-center shadow-xl shadow-indigo-200 group-hover:scale-110 transition-transform">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <span class="text-3xl font-bold tracking-tight text-slate-800">Easy<span class="gradient-text">Coloc</span></span>
                </a>
            </div>

            <div class="w-full sm:max-w-md bg-white p-8 md:p-10 rounded-[2.5rem] shadow-2xl border border-slate-100 relative z-10">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
