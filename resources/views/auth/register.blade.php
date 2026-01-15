<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar | NebengApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .slide-up { animation: slideUp 0.6s ease-out; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-slate-50 antialiased">
    <div class="min-h-screen flex items-center justify-center py-12 px-6">
        <div class="w-full max-w-4xl bg-white rounded-[50px] overflow-hidden shadow-2xl shadow-slate-200 flex flex-col md:flex-row border border-slate-100 slide-up">
            
            <div class="w-full md:w-5/12 bg-emerald-500 p-12 text-white flex flex-col justify-between">
                <div>
                    <h2 class="text-3xl font-black leading-tight mb-4 italic uppercase">Gabung<br>Sekarang.</h2>
                    <p class="text-emerald-100 font-bold text-xs uppercase tracking-widest leading-loose">
                        Dapatkan akses ke ratusan driver mahasiswa dan hemat biaya transport harian mu.
                    </p>
                </div>
                <div class="mt-10">
                    <p class="text-[10px] font-black text-emerald-900 uppercase tracking-[0.2em]">Verified Student Only</p>
                </div>
            </div>

            <div class="w-full md:w-7/12 p-10 md:p-16">
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-xl">
                        <div class="flex">
                            <div class="ml-3">
                                <h3 class="text-sm font-bold text-red-800 uppercase tracking-wider">Ada Masalah, Bro:</h3>
                                <div class="mt-2 text-xs text-red-700 font-semibold space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <p>• {{ $error }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-4">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-sm font-bold text-slate-700" placeholder="Budi Santoso">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-4">Email Kampus</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-sm font-bold text-slate-700" placeholder="budi@student.ac.id">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-4">Password</label>
                            <input type="password" name="password" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-sm font-bold text-slate-700" placeholder="••••••••">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-4">Konfirmasi</label>
                            <input type="password" name="password_confirmation" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500 text-sm font-bold text-slate-700" placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-5 mt-6 bg-slate-900 text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.3em] shadow-xl hover:bg-emerald-600 transition-all shadow-emerald-200/50">
                        CREATE ACCOUNT →
                    </button>
                    
                    <div class="mt-6 text-center">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            Sudah punya akun? <a href="{{ route('login') }}" class="text-emerald-500 hover:text-emerald-600 underline">Login di sini</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>