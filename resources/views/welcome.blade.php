<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>EasyColoc - Simple Roommate Management</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Outfit', sans-serif; }
            .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
            .gradient-text { background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
            .gradient-bg { background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); }
        </style>
    </head>
    <body class="antialiased bg-slate-50 text-slate-900 selection:bg-indigo-100 selection:text-indigo-900">
        <!-- Navigation -->
        <nav class="fixed top-0 left-0 right-0 z-50 glass border-b border-slate-200/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 gradient-bg rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <span class="text-2xl font-bold tracking-tight text-slate-800">Easy<span class="gradient-text">Coloc</span></span>
                    </div>
                    <div class="hidden md:flex items-center gap-8">
                        <a href="#features" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">Features</a>
                        <a href="#about" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">About</a>
                        @if (Route::has('login'))
                            <div class="flex items-center gap-4">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 rounded-full text-sm font-semibold text-white gradient-bg shadow-md shadow-indigo-200 hover:opacity-90 transition-all">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-indigo-600">Log in</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-full text-sm font-semibold text-white gradient-bg shadow-md shadow-indigo-200 hover:opacity-90 transition-all">Get Started</a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <main>
            <!-- Hero Section -->
            <section class="relative pt-32 pb-20 md:pt-48 md:pb-32 overflow-hidden">
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full -z-10">
                    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-200/30 blur-[120px] rounded-full"></div>
                    <div class="absolute bottom-[10%] right-[-5%] w-[30%] h-[30%] bg-purple-200/30 blur-[100px] rounded-full"></div>
                </div>
                
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-slate-900 mb-6 drop-shadow-sm">
                        Manage your colocation <br/>
                        <span class="gradient-text italic">effortlessly.</span>
                    </h1>
                    <p class="max-w-2xl mx-auto text-lg md:text-xl text-slate-600 mb-10 leading-relaxed">
                        Split bills, track expenses, and manage your shared home without the headaches. 
                        The all-in-one platform designed for modern roommates.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 rounded-full text-lg font-bold text-white gradient-bg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform">
                            Create a Coloc
                        </a>
                        <a href="#features" class="w-full sm:w-auto px-8 py-4 rounded-full text-lg font-bold text-indigo-600 bg-white border-2 border-indigo-50 shadow-sm hover:bg-slate-50 transition-colors">
                            How it works
                        </a>
                    </div>
                </div>
                
                <!-- Simple Mockup -->
                <div class="mt-20 max-w-5xl mx-auto px-4 animate-fade-in-up">
                    <div class="bg-white rounded-2xl shadow-2xl p-4 md:p-8 border border-slate-200 relative overflow-hidden">
                        <div class="flex items-center gap-2 mb-6 text-slate-400">
                             <div class="w-3 h-3 rounded-full bg-red-400"></div>
                             <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                             <div class="w-3 h-3 rounded-full bg-green-400"></div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="col-span-2 space-y-6">
                                <div class="h-8 bg-slate-100 rounded-lg w-1/3"></div>
                                <div class="space-y-3">
                                    <div class="h-4 bg-slate-50 rounded w-full"></div>
                                    <div class="h-4 bg-slate-50 rounded w-5/6"></div>
                                    <div class="h-4 bg-slate-50 rounded w-4/6"></div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="h-32 bg-indigo-50/50 rounded-xl border border-indigo-100 flex flex-col justify-end p-4">
                                        <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest mb-1">Total Spent</span>
                                        <span class="text-2xl font-bold text-indigo-700">€ 1,245.00</span>
                                    </div>
                                    <div class="h-32 bg-emerald-50/50 rounded-xl border border-emerald-100 flex flex-col justify-end p-4">
                                        <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest mb-1">Your Balance</span>
                                        <span class="text-2xl font-bold text-emerald-700">+ € 42.10</span>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-6">
                                <div class="h-8 bg-slate-100 rounded-lg w-1/2"></div>
                                <div class="p-4 rounded-xl border border-slate-100 space-y-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs uppercase">JD</div>
                                        <div class="flex-1 h-3 bg-slate-100 rounded"></div>
                                    </div>
                                    <div class="flex items-center gap-3 text-emerald-500">
                                        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-xs uppercase">JS</div>
                                        <div class="flex-1 h-3 bg-slate-100 rounded"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Features Section -->
            <section id="features" class="py-20 md:py-32 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-20">
                        <span class="text-indigo-600 font-bold tracking-widest uppercase text-sm mb-4 block">Features</span>
                        <h2 class="text-4xl md:text-5xl font-bold text-slate-900">Tailored for your home</h2>
                    </div>
                    
                    <div class="grid md:grid-cols-3 gap-12">
                        <!-- Feature 1 -->
                        <div class="group p-8 rounded-3xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100">
                            <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-3">Fair Expense Sharing</h3>
                            <p class="text-slate-600 leading-relaxed">Track every receipt and split costs fairly between all members with automated balance calculations.</p>
                        </div>
                        
                        <!-- Feature 2 -->
                        <div class="group p-8 rounded-3xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100">
                            <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center text-purple-600 mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-3">Roommate Management</h3>
                            <p class="text-slate-600 leading-relaxed">Easily invite new roommates via secure links or email. Manage roles and track who's in the house.</p>
                        </div>
                        
                        <!-- Feature 3 -->
                        <div class="group p-8 rounded-3xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100">
                            <div class="w-14 h-14 bg-rose-100 rounded-2xl flex items-center justify-center text-rose-600 mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-3">Financial Reputation</h3>
                            <p class="text-slate-600 leading-relaxed">Built-in reputation system encourages fair behavior. Stay in the green by keeping your payments up to date.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Stats Section -->
            <section class="py-20 bg-indigo-900 text-white overflow-hidden relative">
                 <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_50%_50%,#fff,transparent)] transform scale-150"></div>
                 <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
                    <div class="grid md:grid-cols-4 gap-12">
                        <div>
                            <div class="text-4xl font-extrabold mb-2">10k+</div>
                            <div class="text-indigo-200 text-sm font-medium uppercase tracking-widest">Active Colocs</div>
                        </div>
                        <div>
                            <div class="text-4xl font-extrabold mb-2">€ 2M+</div>
                            <div class="text-indigo-200 text-sm font-medium uppercase tracking-widest">Expenses Shared</div>
                        </div>
                        <div>
                            <div class="text-4xl font-extrabold mb-2">99.9%</div>
                            <div class="text-indigo-200 text-sm font-medium uppercase tracking-widest">Peace of Mind</div>
                        </div>
                        <div>
                            <div class="text-4xl font-extrabold mb-2">4.9/5</div>
                            <div class="text-indigo-200 text-sm font-medium uppercase tracking-widest">Rating</div>
                        </div>
                    </div>
                 </div>
            </section>

            <!-- CTA Section -->
            <section class="py-24 bg-slate-50">
                <div class="max-w-4xl mx-auto px-4 text-center">
                    <div class="bg-white p-12 md:p-20 rounded-[3rem] shadow-xl border border-slate-100 flex flex-col items-center">
                        <h2 class="text-4xl md:text-5xl font-bold text-slate-900 mb-8 leading-tight">Ready to simplify <br/> your life?</h2>
                        <p class="text-slate-600 text-lg mb-12">Start managing your shared home for free today. No credit card required.</p>
                        <a href="{{ route('register') }}" class="px-10 py-5 rounded-full text-xl font-bold text-white gradient-bg shadow-2xl shadow-indigo-300 hover:scale-110 transition-transform">
                            Join EasyColoc Now
                        </a>
                    </div>
                </div>
            </section>
        </main>

        <footer class="py-12 border-t border-slate-200 bg-white">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p class="text-slate-400 text-sm">&copy; {{ date('Y') }} EasyColoc. Made with ❤️ for roommates everywhere.</p>
            </div>
        </footer>
    </body>
</html>
