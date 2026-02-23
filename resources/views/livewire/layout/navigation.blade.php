<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav class="fixed top-0 left-0 right-0 z-50 glass border-b border-slate-200/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-2">
                        <div class="w-10 h-10 gradient-bg rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <span class="text-2xl font-bold tracking-tight text-slate-800">Easy<span class="gradient-text">Coloc</span></span>
                    </a>
                </div>

                <div class="hidden space-x-2 sm:-my-px sm:ms-10 sm:flex items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('colocations.index')" :active="request()->routeIs('colocations.*')" wire:navigate>
                        {{ __('Colocations') }}
                    </x-nav-link>
                    @if(auth()->user()->isAdmin())
                    <x-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.index')" wire:navigate>
                        {{ __('Admin') }}
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-3 px-4 py-2 bg-slate-50 border border-slate-200 rounded-full text-sm font-semibold text-slate-700 hover:bg-slate-100 hover:border-slate-300 transition-all duration-200">
                            <div class="w-7 h-7 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-[10px] ring-2 ring-white">
                                {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}{{ strtoupper(substr(auth()->user()->last_name, 0, 1)) }}
                            </div>
                            <span>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</span>
                            <svg class="w-4 h-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate class="font-medium text-slate-700">
                            {{ __('Profile Settings') }}
                        </x-dropdown-link>

                        <div class="border-t border-slate-100 my-1"></div>

                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link class="text-red-600 font-medium hover:bg-red-50">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button id="mobile-menu-trigger" class="p-2 rounded-xl text-slate-400 hover:text-slate-500 hover:bg-slate-100 transition-colors">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path id="hamburger-icon" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="hidden sm:hidden bg-white border-b border-slate-100 overflow-hidden transition-all duration-300 max-h-0">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('colocations.index')" :active="request()->routeIs('colocations.*')" wire:navigate>
                {{ __('Colocations') }}
            </x-responsive-nav-link>
            @if(auth()->user()->isAdmin())
            <x-responsive-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.index')" wire:navigate>
                {{ __('Admin') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-slate-100 px-4">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-sm ring-2 ring-white">
                    {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}{{ strtoupper(substr(auth()->user()->last_name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-bold text-slate-900">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                    <div class="text-sm text-slate-500 font-medium">{{ auth()->user()->email }}</div>
                </div>
            </div>

            <div class="space-y-1 mb-4">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Profile Settings') }}
                </x-responsive-nav-link>

                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link class="text-red-600 hover:bg-red-50">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const trigger = document.getElementById('mobile-menu-trigger');
            const menu = document.getElementById('mobile-menu');
            const hamburgerIcon = document.getElementById('hamburger-icon');
            const closeIcon = document.getElementById('close-icon');

            trigger.addEventListener('click', () => {
                const isOpen = !menu.classList.contains('hidden');
                if (isOpen) {
                    menu.style.maxHeight = '0';
                    setTimeout(() => menu.classList.add('hidden'), 300);
                    hamburgerIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                } else {
                    menu.classList.remove('hidden');
                    // Force reflow
                    menu.offsetHeight;
                    menu.style.maxHeight = '400px';
                    hamburgerIcon.classList.add('hidden');
                    closeIcon.classList.remove('hidden');
                }
            });
        })();
    </script>
</nav>
