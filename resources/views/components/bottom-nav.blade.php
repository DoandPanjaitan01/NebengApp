<div class="fixed bottom-6 left-0 right-0 px-6 z-50">
    <div class="max-w-md mx-auto bg-white/90 backdrop-blur-md border border-slate-100 rounded-[30px] shadow-2xl px-6 py-3 flex justify-between items-center">
        
        <a href="{{ url('/dashboard') }}" class="flex flex-col items-center gap-1">
            <svg class="w-6 h-6 {{ Request::is('dashboard*') ? 'text-emerald-500' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="text-[10px] font-black {{ Request::is('dashboard*') ? 'text-emerald-500' : 'text-slate-400' }}">BERANDA</span>
        </a>

        <a href="{{ url('/activities') }}" class="flex flex-col items-center gap-1">
            <svg class="w-6 h-6 {{ Request::is('activities*') ? 'text-emerald-500' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <span class="text-[10px] font-black {{ Request::is('activities*') ? 'text-emerald-500' : 'text-slate-400' }}">AKTIVITAS</span>
        </a>

        <div class="relative -mt-12">
            <a href="{{ url('/dashboard') }}" class="w-14 h-14 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200 border-4 border-white">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M12 4v16m8-8H4"/></svg>
            </a>
        </div>

        <a href="{{ url('/chat') }}" class="flex flex-col items-center gap-1">
            <svg class="w-6 h-6 {{ Request::is('chat*') || Request::is('bookings/*/chat') ? 'text-emerald-500' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <span class="text-[10px] font-black {{ Request::is('chat*') || Request::is('bookings/*/chat') ? 'text-emerald-500' : 'text-slate-400' }}">CHAT</span>
        </a>

        <a href="{{ url('/profile') }}" class="flex flex-col items-center gap-1">
            <svg class="w-6 h-6 {{ Request::is('profile*') ? 'text-emerald-500' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span class="text-[10px] font-black {{ Request::is('profile*') ? 'text-emerald-500' : 'text-slate-400' }}">PROFIL</span>
        </a>
    </div>
</div>