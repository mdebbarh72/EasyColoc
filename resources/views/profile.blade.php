<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold tracking-tight text-slate-900">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 p-6 sm:p-10 border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full -mr-16 -mt-16 -z-0 opacity-50"></div>
                <div class="relative z-10">
                    <div class="max-w-2xl">
                        <livewire:profile.update-profile-information-form />
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 p-6 sm:p-10 border border-slate-100 relative overflow-hidden">
                <div class="absolute bottom-0 right-0 w-32 h-32 bg-purple-50 rounded-full -mr-16 -mb-16 -z-0 opacity-50"></div>
                <div class="relative z-10">
                    <div class="max-w-2xl">
                        <livewire:profile.update-password-form />
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 p-6 sm:p-10 border border-red-50 relative overflow-hidden">
                <div class="absolute top-1/2 right-0 w-32 h-32 bg-red-50 rounded-full -mr-16 -translate-y-1/2 -z-0 opacity-50"></div>
                <div class="relative z-10 text-red-600">
                    <div class="max-w-2xl">
                        <livewire:profile.delete-user-form />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
