<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password | NebengApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .fade-up { animation: fadeUp 0.6s ease-out; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-slate-50 antialiased">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-md bg-white rounded-[40px] p-10 shadow-2xl shadow-slate-200/50 border border-slate-100 fade-up">
            
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-100 text-emerald-600 rounded-2xl mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d=" activist-key-icon M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-[800] text-slate-900 tracking-tighter mb-4 uppercase italic">Lupa Sandi?</h1>
                <p class="text-slate-500 font-bold text-[10px] uppercase tracking-widest leading-relaxed px-4">
                    Tenang, masukin email kampus lo di bawah. Kita kirim link buat bikin password baru.
                </p>
            </div>

            @if (session('status'))
                <div class="mb-6 p-4 bg-emerald-50 rounded-2xl border border-emerald-100 text-[10px] font-bold text-emerald-700 uppercase tracking-widest text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-4">Email Terdaftar</label>
                    <input type="email" name="email" :value="old('email')" required autofocus class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-sm font-bold text-slate-700 placeholder:text-slate-300 transition-all" placeholder="nama@mahasiswa.ac.id">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 ml-4" />
                </div>

                <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.3em] shadow-xl hover:bg-emerald-600 hover:scale-[1.02] active:scale-95 transition-all">
                    KIRIM LINK RESET →
                </button>
            </form>

            <div class="mt-10 text-center">
                <a href="{{ route('login') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-emerald-500 transition-colors flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali Login
                </a>
            </div>
        </div>
    </div>
</body>
</html>