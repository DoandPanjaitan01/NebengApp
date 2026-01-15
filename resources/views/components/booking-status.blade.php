<div wire:poll.3s> {{-- Auto update data setiap 3 detik --}}
    @if($booking)
        <div class="bg-white rounded-[40px] border-2 {{ $booking->status == 'searching' ? 'border-amber-400' : 'border-emerald-500' }} p-8 shadow-2xl relative overflow-hidden mb-6 transition-all duration-500">
            
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <div class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $booking->status == 'searching' ? 'bg-amber-400' : 'bg-emerald-400' }} opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 {{ $booking->status == 'searching' ? 'bg-amber-500' : 'bg-emerald-500' }}"></span>
                    </div>
                    <span class="text-[11px] font-black uppercase tracking-widest text-slate-900">
                        {{ $booking->status == 'searching' ? 'Mencari Driver...' : 'Driver Ditemukan!' }}
                    </span>
                </div>
            </div>

            <div class="space-y-4 mb-8">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-3xl shadow-inner border border-slate-100">
                        {{ $booking->vehicle_type == 'motor' ? '🏍️' : '🚗' }}
                    </div>
                    <div class="flex-1">
                        <p class="text-[9px] font-black text-slate-400 uppercase leading-none mb-1 tracking-tighter">Lokasi Tujuan</p>
                        <p class="font-black text-slate-800 leading-tight truncate text-lg">{{ $booking->destination_point }}</p>
                    </div>
                </div>
            </div>

            @if($booking->status == 'accepted' && $booking->trip)
                <div class="bg-emerald-50 border-2 border-emerald-100 rounded-[30px] p-5 mb-6 flex items-center gap-4">
                    <div class="w-14 h-14 bg-white rounded-2xl border-2 border-emerald-500 overflow-hidden shadow-md flex items-center justify-center text-xl font-black text-emerald-500">
                        {{ substr($booking->trip->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-emerald-600 uppercase tracking-tighter mb-1 leading-none">Driver Lo</p>
                        <p class="font-black text-slate-900 text-lg leading-none">{{ $booking->trip->user->name }}</p>
                    </div>
                    <a href="tel:{{ $booking->trip->user->phone ?? '#' }}" class="ml-auto w-12 h-12 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </a>
                </div>
            @endif

            <div class="flex justify-between items-end border-t border-dashed border-slate-100 pt-5">
                <div>
                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-tighter">Biaya Nebeng</p>
                    <p class="text-2xl font-black text-slate-900 tracking-tighter italic leading-none">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</p>
                </div>
                @if($booking->status == 'searching')
                    <button class="bg-slate-100 text-slate-400 px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-50 hover:text-red-500 transition-all">Batalkan</button>
                @endif
            </div>
        </div>
    @endif
</div>