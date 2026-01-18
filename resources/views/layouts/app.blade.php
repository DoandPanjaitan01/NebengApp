<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NebengApp - Solusi Ride Sharing Medan</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: { 'gojek': '#00AA13', 'grab': '#00B14F' }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; -webkit-tap-highlight-color: transparent; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-[#F6F8FB] antialiased text-slate-900">
    <div class="min-h-screen">
        <main>
            {{ $slot }}
        </main>

        <nav class="fixed bottom-0 left-0 right-0 z-50 flex justify-center pb-6 px-4 pointer-events-none">
            <div class="w-full max-w-md bg-white/80 backdrop-blur-xl border border-white/20 shadow-[0_20px_50px_rgba(0,0,0,0.15)] rounded-[32px] pointer-events-auto overflow-hidden">
                <div class="flex justify-around items-center h-20 px-2">
                    
                    <a href="{{ route('dashboard') }}" class="flex flex-col items-center flex-1 {{ request()->is('dashboard*') ? 'text-emerald-600' : 'text-slate-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span class="text-[10px] font-bold mt-1 uppercase tracking-tighter">Beranda</span>
                    </a>

                    <a href="{{ route('activities.index') }}" class="flex flex-col items-center flex-1 {{ request()->is('activities*') ? 'text-emerald-600' : 'text-slate-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 002-2h2a2 2 0 012 2"/></svg>
                        <span class="text-[10px] font-bold mt-1 uppercase tracking-tighter">Aktivitas</span>
                    </a>

                    <div class="flex-1 flex justify-center -mt-10">
                        <a href="{{ route('dashboard') }}" class="w-16 h-16 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-emerald-200 border-4 border-white transform hover:scale-110 transition">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                        </a>
                    </div>

                    <a href="{{ url('/chat') }}" class="flex flex-col items-center flex-1 {{ (request()->is('chat*') || request()->is('bookings/*/chat')) ? 'text-emerald-600' : 'text-slate-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        <span class="text-[10px] font-bold mt-1 uppercase tracking-tighter">Chat</span>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="flex flex-col items-center flex-1 {{ request()->is('profile*') ? 'text-emerald-600' : 'text-slate-400' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span class="text-[10px] font-bold mt-1 uppercase tracking-tighter">Profil</span>
                    </a>

                </div>
            </div>
        </nav>
    </div>
</body>
</html>