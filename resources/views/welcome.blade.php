<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NebengApp - Solusi Kampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 antialiased overflow-x-hidden">
    
    <div class="relative min-h-screen flex items-center justify-center py-20">
        <div class="absolute inset-0 z-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-emerald-400 rounded-full mix-blend-multiply filter blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-5xl mx-auto px-6 text-center">
            <div class="inline-block px-4 py-2 bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-[0.2em] rounded-full mb-8">
                🚀 Teman Perjalanan Kampus Mu
            </div>
            
            <h1 class="text-6xl md:text-8xl font-[800] text-slate-900 leading-[0.9] tracking-tighter mb-8">
                NEBENG<span class="text-emerald-500">.</span>APP
            </h1>
            
            <p class="text-lg md:text-xl text-slate-500 font-medium max-w-2xl mx-auto mb-12 leading-relaxed">
                Nggak perlu mahal buat ke kampus. Cari tebengan aman, murah, dan seru bareng mahasiswa lainnya.
            </p>

            @if (Route::has('login'))
                <div class="flex flex-col md:flex-row items-center justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="group relative px-10 py-5 bg-slate-900 text-white rounded-[2rem] font-black text-sm uppercase tracking-widest overflow-hidden shadow-2xl transition-all hover:scale-105 active:scale-95">
                            <span class="relative z-10">Buka Dashboard →</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-10 py-5 bg-slate-900 text-white rounded-[2rem] font-black text-sm uppercase tracking-widest shadow-2xl hover:bg-emerald-600 transition-all hover:scale-105">
                            Mulai Nebeng
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-10 py-5 bg-white text-slate-900 border border-slate-200 rounded-[2rem] font-black text-sm uppercase tracking-widest shadow-sm hover:bg-slate-50 transition-all hover:scale-105">
                                Daftar Akun
                            </a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="mt-24 grid grid-cols-2 md:grid-cols-3 gap-8 border-t border-slate-200 pt-12">
                <div class="text-left">
                    <p class="text-3xl font-black text-slate-900 italic">500+</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Driver Aktif</p>
                </div>
                <div class="text-left">
                    <p class="text-3xl font-black text-slate-900 italic">1.2k</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Perjalanan Selesai</p>
                </div>
                <div class="hidden md:block text-left">
                    <p class="text-3xl font-black text-emerald-500 italic">Mulai 5rb</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Harga Per KM</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="py-10 text-center border-t border-slate-100">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">© 2026 NebengApp Dev. Built for Students.</p>
    </footer>

</body>
</html>