<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk | NebengApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .fade-in { animation: fadeIn 0.8s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-white antialiased overflow-hidden">
    <div class="flex min-h-screen">
        <div class="hidden lg:flex lg:w-1/2 bg-slate-900 items-center justify-center relative p-12">
            <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
            <div class="relative z-10 text-center fade-in">
                <div class="w-24 h-1 bg-emerald-500 mx-auto mb-8 rounded-full"></div>
                <h2 class="text-5xl font-black text-white leading-tight mb-6">HEMAT ONGKOS,<br><span class="text-emerald-400 italic">BANYAK TEMAN.</span></h2>
                <p class="text-slate-400 font-medium text-lg max-w-md mx-auto italic underline decoration-emerald-500/50 underline-offset-8">
                    "Nebeng itu bukan cuma soal sampai tujuan, tapi soal solidaritas mahasiswa."
                </p>
            </div>
            <div class="absolute bottom-10 left-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl"></div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 md:p-16 bg-slate-50">
            <div class="w-full max-w-md fade-in" style="animation-delay: 0.2s;">
                <div class="mb-10 text-center lg:text-left">
                    <h1 class="text-4xl font-[800] text-slate-900 tracking-tighter mb-2 uppercase italic">Masuk<span class="text-emerald-500">.</span></h1>
                    <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest">Ayo berangkat kuliah sekarang!</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div class="group">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-4">Email Kampus</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-bold text-slate-700 shadow-sm transition-all" placeholder="nama@mahasiswa.ac.id">
                    </div>

                    <div class="group">
                        <div class="flex justify-between items-center mb-2 ml-4">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Password</label>
                            <a href="{{ route('password.request') }}" class="text-[9px] font-black text-emerald-500 uppercase hover:text-slate-900 transition-colors">Lupa?</a>
                        </div>
                        <input type="password" name="password" required class="w-full px-6 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-bold text-slate-700 shadow-sm transition-all" placeholder="••••••••">
                    </div>

                    <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.3em] shadow-xl hover:bg-emerald-600 hover:shadow-emerald-200 transition-all active:scale-95">
                        LOG IN →
                    </button>
                </form>

                <p class="mt-10 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-relaxed">
                    Belum punya akun? <br>
                    <a href="{{ route('register') }}" class="text-emerald-600 hover:text-slate-900 transition-colors border-b-2 border-emerald-500/20">Daftar Akun Kampus</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>