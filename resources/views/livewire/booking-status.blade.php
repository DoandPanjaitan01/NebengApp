<div wire:poll.3s>
    @if($booking)
        <div class="bg-white rounded-[40px] border-2 {{ $booking->status == 'searching' ? 'border-amber-400' : 'border-emerald-500' }} p-8 shadow-2xl relative overflow-hidden mb-6 transition-all duration-500">
            
            {{-- Progress Bar Animasi --}}
            @if($booking->status == 'searching')
                <div class="absolute top-0 left-0 w-full h-1 bg-amber-100 overflow-hidden">
                    <div class="w-1/2 h-full bg-amber-400 animate-progress-bar"></div>
                </div>
            @endif

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
                <span class="text-xs font-bold text-slate-400 italic">{{ $booking->created_at->format('H:i') }} WIB</span>
            </div>

            {{-- Detail Tujuan --}}
            <div class="space-y-4 mb-8">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-3xl shadow-inner border border-slate-100">
                        {{ $booking->vehicle_type == 'motor' ? '🏍️' : '🚗' }}
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-[10px] font-black text-slate-400 uppercase leading-none mb-1">Tujuan Akhir</p>
                        <p class="font-black text-slate-800 leading-tight truncate text-lg">{{ $booking->destination_point }}</p>
                    </div>
                </div>
            </div>

            {{-- INFO DRIVER (Tampil pas Status Accepted) --}}
            @if($booking->status == 'accepted')
                <div class="bg-emerald-50 border-2 border-emerald-100 rounded-[30px] p-5 mb-6 animate-slide-up">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-16 h-16 bg-white rounded-2xl border-2 border-emerald-500 overflow-hidden shadow-md">
                            {{-- Cek apakah ada driver asli, kalo nggak pake dummy --}}
                            @php
                                $driverName = $booking->trip->user->name ?? $driverData['name'];
                                $driverPhoto = "https://ui-avatars.com/api/?name=" . urlencode($driverName) . "&background=10b981&color=fff";
                            @endphp
                            <img src="{{ $driverPhoto }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-emerald-600 uppercase tracking-tighter mb-1">Driver Lo Sekarang</p>
                            <p class="font-black text-slate-900 text-xl leading-none">{{ $driverName }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="bg-emerald-200 text-emerald-700 text-[9px] px-2 py-0.5 rounded-full font-bold">⭐ {{ $driverData['rating'] }}</span>
                                <p class="text-[10px] font-bold text-slate-500 uppercase">{{ $driverData['vehicle'] }} • {{ $driverData['plate'] }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="grid grid-cols-2 gap-3">
                        <a href="tel:{{ $driverData['phone'] }}" class="flex items-center justify-center gap-2 bg-white text-slate-900 border-2 border-slate-100 py-3 rounded-2xl font-black text-[11px] uppercase tracking-tighter hover:bg-slate-50 transition-all">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            Hubungi
                        </a>
                        <button class="flex items-center justify-center gap-2 bg-emerald-500 text-white py-3 rounded-2xl font-black text-[11px] uppercase tracking-tighter shadow-lg shadow-emerald-200 hover:bg-emerald-600 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            Chat Driver
                        </button>
                    </div>
                </div>
            @endif

            <div class="flex justify-between items-end mt-4">
                <div>
                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-tighter">Total Pembayaran</p>
                    <p class="text-2xl font-black text-slate-900 tracking-tighter italic">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                </div>
                @if($booking->status == 'searching')
                    <button class="bg-slate-50 text-slate-400 px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-50 hover:text-red-500 transition-all group">
                        <span class="group-hover:hidden">Mencari...</span>
                        <span class="hidden group-hover:block">Batalkan</span>
                    </button>
                @else
                    <div class="flex flex-col items-end">
                        <p class="text-[9px] font-black text-emerald-500 uppercase mb-1">Metode Pembayaran</p>
                        <p class="text-xs font-bold text-slate-700">NebengPay</p>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>

<style>
    .animate-progress-bar { animation: progress 2s infinite ease-in-out; }
    .animate-slide-up { animation: slideIn 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
    @keyframes progress {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(250%); }
    }
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(30px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
</style>