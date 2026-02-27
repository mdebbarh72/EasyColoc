<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center p-6 bg-slate-50">
        <!-- Background Decoration -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-indigo-100/50 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] bg-purple-100/50 rounded-full blur-3xl"></div>
        </div>

        <div class="relative w-full max-w-lg">
            @if(isset($error))
                <!-- Error State -->
                <div class="bg-white/80 backdrop-blur-xl border border-red-100 rounded-[2.5rem] p-10 shadow-2xl text-center animate-in zoom-in-95">
                    <div class="w-20 h-20 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 14c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-black text-slate-900 mb-3">Invitation Error</h2>
                    <p class="text-slate-500 mb-8 leading-relaxed">{{ $error }}</p>
                    <a href="{{ route('dashboard') }}" class="inline-flex py-4 px-8 bg-slate-900 text-white font-extrabold rounded-2xl hover:bg-slate-800 transition-all shadow-xl shadow-slate-200">
                        Go to Dashboard
                    </a>
                </div>
            @else
                <!-- Success State / Acceptance Modal Preview -->
                <div class="bg-white/90 backdrop-blur-2xl border border-white/20 rounded-[3rem] p-12 shadow-2xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-indigo-50 rounded-bl-full -mr-20 -mt-20 group-hover:bg-indigo-100/50 transition-colors"></div>
                    
                    <div class="relative">
                        <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center mb-8 text-white shadow-xl shadow-indigo-100 animate-bounce">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>

                        <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-tight mb-4">
                            You're invited <br/>to join <span class="text-indigo-600">{{ $invitation->colocation->name }}</span>
                        </h1>
                        <p class="text-slate-500 text-lg mb-10 leading-relaxed font-medium">
                            {{ $invitation->colocation->description ?? 'Someone wants to share their home with you! Simplify expenses and manage your household together.' }}
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4">
                            @auth
                                <form action="{{ route('invitations.accept', $invitation->token) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full py-5 px-8 gradient-bg text-white font-black rounded-2xl shadow-xl shadow-indigo-100 hover:shadow-indigo-200 hover:-translate-y-1 transition-all active:translate-y-0">
                                        Accept Invitation
                                    </button>
                                </form>
                                <form action="{{ route('invitations.deny', $invitation->token) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full py-5 px-8 bg-slate-100 text-slate-600 font-black rounded-2xl hover:bg-slate-200 transition-all">
                                        No Thanks
                                    </button>
                                </form>
                            @else
                                <div class="flex-1 flex flex-col gap-4">
                                    <a href="{{ route('login', ['redirect' => route('invitations.show', $invitation->token)]) }}" class="w-full py-5 px-8 gradient-bg text-white text-center font-black rounded-2xl shadow-xl shadow-indigo-100 hover:shadow-indigo-200 transition-all">
                                        Login to Accept
                                    </a>
                                    <p class="text-xs text-slate-400 text-center uppercase font-black tracking-widest">or</p>
                                    <a href="{{ route('register') }}" class="text-center font-bold text-indigo-600 hover:underline">Create an account first</a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-guest-layout>

<style>
    .gradient-bg {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    }
</style>
