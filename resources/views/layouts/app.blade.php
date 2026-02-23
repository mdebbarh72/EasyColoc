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
            .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); }
            .gradient-bg { background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); }
            .gradient-text { background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        </style>
    </head>
    <body class="antialiased font-sans text-slate-900 bg-slate-50 selection:bg-indigo-100 selection:text-indigo-900">
        <div class="min-h-screen flex flex-col">
            <livewire:layout.navigation />

            @if(session('success'))
                <x-toast wire:key="toast-success-{{ time() }}" type="success" :message="session('success')" />
            @endif

            @if(session('error'))
                <x-toast wire:key="toast-error-{{ time() }}" type="error" :message="session('error')" />
            @endif

            @if(session('warning'))
                <x-toast wire:key="toast-warning-{{ time() }}" type="warning" :message="session('warning')" />
            @endif

            @if(session('status'))
                <x-toast wire:key="toast-info-{{ time() }}" type="info" :message="session('status')" />
            @endif

            <div class="pt-20 flex-1 flex flex-col">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white border-b border-slate-100">
                        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                            <div class="flex items-center gap-4">
                                 <div class="w-1.5 h-8 gradient-bg rounded-full"></div>
                                 {{ $header }}
                            </div>
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main class="flex-1">
                    {{ $slot }}
                </main>
            </div>

            <footer class="py-10 border-t border-slate-200 bg-white mt-auto">
                <div class="max-w-7xl mx-auto px-4 text-center">
                    <p class="text-slate-400 text-sm">&copy; {{ date('Y') }} EasyColoc. All rights reserved.</p>
                </div>
            </footer>
        </div>
    </body>
</html>
