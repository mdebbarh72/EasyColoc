<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-widest italic">
                GLOBAL SUPERVISION
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 flex gap-8">
            
            <!-- Sidebar -->
            <div class="w-64 shrink-0 hidden md:block group">
                <div class="bg-[#1e1b4b] rounded-3xl p-6 min-h-[calc(100vh-12rem)] shadow-xl relative overflow-hidden transition-all duration-300 shadow-indigo-500/10">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-transparent"></div>
                    <div class="relative z-10 flex flex-col h-full">
                        
                        <div class="flex items-center gap-3 mb-10 pb-6 border-b border-indigo-500/20">
                            <div class="w-8 h-8 rounded-lg bg-indigo-500 flex items-center justify-center text-white shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <span class="text-xl font-bold text-white tracking-wide">Admin</span>
                        </div>

                        <nav class="space-y-2 flex-1">
                            <a href="#" class="flex items-center gap-3 px-4 py-3 bg-indigo-500 text-white rounded-xl font-medium shadow-md shadow-indigo-500/20 transition-all">
                                <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                                Statistics
                            </a>

                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-indigo-200/60 hover:text-white hover:bg-white/5 rounded-xl font-medium transition-all group-hover:duration-200">
                                <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Back to app
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 space-y-8 min-w-0">
                
                <!-- KPI Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
                    <!-- Users KPI -->
                    <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex flex-col justify-between">
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Users</p>
                        <h3 class="text-4xl font-black text-slate-900 mb-6 italic">{{ number_format($totalUsers) }}</h3>
                        <div class="mt-auto">
                            <span class="inline-flex px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black tracking-widest uppercase rounded-lg border border-emerald-100/50 shadow-sm">
                                Total
                            </span>
                        </div>
                    </div>

                    <!-- Colocations KPI -->
                    <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex flex-col justify-between">
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Colocations</p>
                        <h3 class="text-4xl font-black text-slate-900 mb-6 italic">{{ number_format($activeColocations) }}</h3>
                        <div class="mt-auto">
                            <span class="inline-flex px-3 py-1 bg-slate-50 text-slate-600 text-[10px] font-black tracking-widest uppercase rounded-lg border border-slate-200 shadow-sm">
                                Active
                            </span>
                        </div>
                    </div>

                    <!-- Expenses KPI -->
                    <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex flex-col justify-between">
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Expenses</p>
                        <h3 class="text-4xl font-black text-slate-900 mb-6 italic">{{ number_format($totalExpenses, 2, ',', ' ') }}</h3>
                        <div class="mt-auto">
                            <span class="inline-flex px-3 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-black tracking-widest uppercase rounded-lg border border-indigo-100 shadow-sm">
                                Total amount
                            </span>
                        </div>
                    </div>

                    <!-- Banned KPI -->
                    <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex flex-col justify-between">
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Banned</p>
                        <h3 class="text-4xl font-black text-red-600 mb-6 italic">{{ number_format($bannedUsersCount) }}</h3>
                        <div class="mt-auto">
                            <span class="inline-flex px-3 py-1 bg-red-50 text-red-600 text-[10px] font-black tracking-widest uppercase rounded-lg border border-red-100 shadow-sm">
                                To monitor
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Users Table Section -->
                <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-8">
                        <h3 class="text-2xl font-black text-slate-800 tracking-tight">User Management</h3>
                        
                        <form method="GET" action="{{ route('admin.index') }}" class="relative w-full sm:max-w-xs">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search email..." 
                                class="w-full pl-6 pr-14 py-3 bg-slate-50 border-transparent focus:bg-white focus:ring-2 focus:ring-indigo-500 rounded-2xl shadow-sm text-sm font-medium transition-all">
                            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 p-2 bg-[#0f172a] text-white hover:bg-indigo-600 rounded-xl transition-colors shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>
                        </form>
                    </div>

                    <div class="overflow-x-auto overflow-y-hidden pb-4">
                        <table class="w-full text-left min-w-[800px]">
                            <thead>
                                <tr class="border-b border-slate-100">
                                    <th class="pb-6 px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest w-24">ID</th>
                                    <th class="pb-6 px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest w-48">User</th>
                                    <th class="pb-6 px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Email</th>
                                    <th class="pb-6 px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center w-32">Reputation</th>
                                    <th class="pb-6 px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center w-32">Status</th>
                                    <th class="pb-6 px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right w-32">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($users as $user)
                                    <tr class="hover:bg-slate-50/50 transition-colors group">
                                        <td class="py-5 px-4">
                                            <span class="text-xs font-bold text-slate-400">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
                                        </td>
                                        <td class="py-5 px-4 font-black text-slate-800">
                                            {{ $user->first_name }} {{ $user->last_name }}
                                        </td>
                                        <td class="py-5 px-4 text-sm font-medium text-slate-500 italic">
                                            {{ $user->email }}
                                        </td>
                                        <td class="py-5 px-4 text-center">
                                            <span class="text-sm font-black text-emerald-600">{{ $user->reputation }} pts</span>
                                        </td>
                                        <td class="py-5 px-4 text-center">
                                            @if($user->isBanned())
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-50 text-red-600 text-[10px] font-black tracking-widest uppercase rounded-lg">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Banned
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black tracking-widest uppercase rounded-lg">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-5 px-4 text-right">
                                            <form action="{{ route('admin.users.ban', $user) }}" method="POST" class="inline">
                                                @csrf
                                                @if($user->isBanned())
                                                    <button type="submit" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-sm">
                                                        Unban
                                                    </button>
                                                @else
                                                    <button type="submit" onclick="return confirm('Do you really want to ban this user?')" class="px-4 py-2 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-sm shadow-red-100 hover:shadow-red-200">
                                                        Ban
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-12 text-center">
                                            <div class="text-slate-400 font-medium mb-2">No users found.</div>
                                            @if(request('search'))
                                                <a href="{{ route('admin.index') }}" class="text-sm text-indigo-600 hover:underline font-bold">Reset search</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($users->hasPages())
                        <div class="mt-8 border-t border-slate-100 pt-6">
                            {{ $users->links() }}
                        </div>
                    @else
                        <div class="mt-6 pt-4 border-t border-slate-100 text-xs font-bold text-slate-400 uppercase tracking-widest">
                            Showing {{ $users->count() }} users
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
