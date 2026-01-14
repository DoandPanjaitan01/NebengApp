<x-app-layout>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-40">
        <div class="relative mt-8 mb-16">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 via-white to-slate-50 rounded-[50px] -z-10 shadow-sm border border-white"></div>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center p-8 lg:p-14">
                <div class="lg:col-span-7">
                    <h1 class="text-5xl lg:text-6xl font-black text-slate-900 tracking-tight mb-6 leading-[1.1]">
                        Halo, <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500">{{ Auth::user()->name }}!</span> 🚀
                    </h1>
                    <p class="text-slate-500 text-xl font-medium max-w-md">Tentukan titik jemput dan antar lo sekarang.</p>
                </div>
                <div class="lg:col-span-5">
                    <div class="bg-slate-900 rounded-[45px] p-10 shadow-2xl relative overflow-hidden group border border-slate-800">
                        <p class="text-emerald-400 text-[10px] font-bold uppercase tracking-[0.2em] mb-2">Saldo NebengPay</p>
                        <h2 class="text-4xl font-black text-white tracking-tighter mb-10">
                            Rp {{ number_format(Auth::user()->balance, 0, ',', '.') }}
                        </h2>
                        <div class="grid grid-cols-2 gap-4">
                            <button class="bg-emerald-500 text-white py-4 rounded-[22px] text-xs font-black uppercase tracking-widest shadow-lg shadow-emerald-500/30">Top Up</button>
                            <a href="{{ route('activities.index') }}" class="bg-white/5 text-center text-white py-4 rounded-[22px] text-xs font-black border border-white/10 uppercase tracking-widest">Riwayat</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            {{-- FIX: Ganti $trips menjadi $drivers agar sinkron dengan Controller --}}
            @forelse($drivers as $trip)
                <div x-data="{ 
                        distance: 1, 
                        pricePerKm: {{ $trip->price }},
                        get total() { return this.distance * this.pricePerKm },
                        formatCurrency(val) {
                            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val);
                        }
                    }" 
                    class="group bg-white rounded-[50px] border border-slate-100 p-8 shadow-sm hover:shadow-2xl transition-all duration-500 relative overflow-hidden">
                    
                    <div class="flex justify-between items-center mb-8 relative z-10">
                        <div class="flex items-center space-x-4">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($trip->driver->name) }}&background=0f172a&color=fff&bold=true" class="w-14 h-14 rounded-[20px]">
                            <div>
                                <h4 class="text-base font-black text-slate-900">{{ $trip->driver->name }}</h4>
                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[9px] font-black rounded-md uppercase">Partner</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-black text-slate-900">Rp {{ number_format($trip->price/1000, 0) }}k/km</p>
                            <p class="text-[9px] text-slate-400 font-bold uppercase">Tarif Flat</p>
                        </div>
                    </div>

                    {{-- FIX: Pastikan route name-nya benar sesuai di web.php (trips.book) --}}
                    <form action="{{ route('trips.book') }}" method="POST">
                        @csrf
                        <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                        
                        <div class="bg-slate-50 rounded-[35px] p-7 mb-8 space-y-6 border border-slate-100">
                            <input type="text" name="pickup_point" required placeholder="Titik Jemput..." class="w-full bg-white border-none rounded-xl text-xs font-bold p-3.5 shadow-sm focus:ring-2 focus:ring-emerald-500">
                            <input type="text" name="destination_point" required placeholder="Tujuan Kampus..." class="w-full bg-white border-none rounded-xl text-xs font-bold p-3.5 shadow-sm focus:ring-2 focus:ring-emerald-500">
                            
                            <div class="pt-4">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2" x-text="'Jarak Jauh: ' + distance + ' Km'"></label>
                                <input type="range" name="distance" min="1" max="40" x-model="distance" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-emerald-500">
                            </div>

                            <div class="bg-emerald-600 rounded-2xl p-4 flex justify-between items-center shadow-lg shadow-emerald-200">
                                <div class="text-left">
                                    <p class="text-[8px] text-emerald-200 font-bold uppercase tracking-widest mb-1">Total Bayar</p>
                                    <p class="text-base font-black text-white" x-text="formatCurrency(total)"></p>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full py-5 bg-slate-900 text-white text-[11px] font-black rounded-[25px] shadow-xl hover:bg-emerald-600 transition-all uppercase tracking-widest">
                            KONFIRMASI SEKARANG
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-white rounded-[50px] border-2 border-dashed border-slate-100">
                    <p class="text-slate-400 font-bold uppercase tracking-widest">Belum ada tebengan tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>