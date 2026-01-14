<div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-[90%] max-w-md bg-white/80 backdrop-blur-xl border border-white shadow-2xl rounded-[35px] px-8 py-4 flex justify-between items-center z-50">
    <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('dashboard') ? 'text-emerald-500' : 'text-slate-400' }}">
        <span class="text-xl">🏠</span>
        <span class="text-[10px] font-black uppercase tracking-tighter">Beranda</span>
    </a>
    <a href="{{ route('activities.index') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('activities.index') ? 'text-emerald-500' : 'text-slate-400' }}">
        <span class="text-xl">📋</span>
        <span class="text-[10px] font-black uppercase tracking-tighter">Aktivitas</span>
    </a>
    <div class="w-14 h-14 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200 -mt-10 border-4 border-[#F4F7FE]">
        <span class="text-2xl">➕</span>
    </div>
    <a href="#" class="flex flex-col items-center gap-1 text-slate-400">
        <span class="text-xl">💬</span>
        <span class="text-[10px] font-black uppercase tracking-tighter">Chat</span>
    </a>
    <a href="{{ route('profile.edit') }}" class="flex flex-col items-center gap-1 text-slate-400">
        <span class="text-xl">👤</span>
        <span class="text-[10px] font-black uppercase tracking-tighter">Profil</span>
    </a>
</div>