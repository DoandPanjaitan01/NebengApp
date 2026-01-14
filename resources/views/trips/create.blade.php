<x-app-layout>
    <div class="max-w-md mx-auto px-6 py-10">
        <div class="mb-8">
            <h1 class="text-3xl font-black text-slate-900 italic tracking-tighter">BUKA JASA TEBENGAN 🚀</h1>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2">Bantu temen, dapet cuan.</p>
        </div>

        <form action="{{ route('trips.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="bg-white p-6 rounded-[30px] shadow-xl shadow-slate-200/50 border border-slate-50 space-y-4">
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Titik Keberangkatan</label>
                    <input type="text" name="origin" placeholder="Contoh: Gerbang Depan USU" required
                        class="w-full mt-1 bg-slate-50 border-none rounded-2xl px-4 py-4 text-sm font-bold focus:ring-2 focus:ring-emerald-500 transition-all">
                </div>

                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Tujuan Akhir</label>
                    <input type="text" name="destination" placeholder="Contoh: Jl. Dr. Mansyur" required
                        class="w-full mt-1 bg-slate-50 border-none rounded-2xl px-4 py-4 text-sm font-bold focus:ring-2 focus:ring-emerald-500 transition-all">
                </div>
            </div>

            <div class="bg-white p-6 rounded-[30px] shadow-xl shadow-slate-200/50 border border-slate-50 grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Waktu Berangkat</label>
                    <input type="datetime-local" name="departure_time" required
                        class="w-full mt-1 bg-slate-50 border-none rounded-2xl px-4 py-4 text-sm font-bold focus:ring-2 focus:ring-emerald-500">
                </div>
                
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Harga / KM</label>
                    <input type="number" name="price" value="5000" required
                        class="w-full mt-1 bg-slate-50 border-none rounded-2xl px-4 py-4 text-sm font-bold focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2">Kursi Kosong</label>
                    <input type="number" name="empty_seats" value="1" min="1" required
                        class="w-full mt-1 bg-slate-50 border-none rounded-2xl px-4 py-4 text-sm font-bold focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white py-5 rounded-[25px] font-black uppercase tracking-[0.2em] text-xs shadow-2xl shadow-slate-400 hover:bg-emerald-600 hover:-translate-y-1 transition-all duration-300">
                Publish Rute Sekarang
            </button>
        </form>
    </div>
</x-app-layout>