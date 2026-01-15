<x-app-layout>
    <div class="min-h-screen bg-white pb-24">
        <div class="max-w-xl mx-auto px-6 pt-12">
            
            <div class="flex items-center justify-between mb-10">
                <h1 class="text-4xl font-black text-slate-900 tracking-tighter italic">Aktivitas Lo ⚡</h1>
                <a href="{{ route('dashboard') }}" class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
            </div>

            <div class="mb-12">
                <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6">Pesanan Berjalan</h2>
                
                @forelse($activeBookings as $booking)
                <div class="bg-white rounded-[40px] border-2 {{ $booking->status == 'searching' ? 'border-amber-400' : 'border-emerald-500' }} p-8 shadow-2xl relative overflow-hidden mb-6">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-3">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $booking->status == 'searching' ? 'bg-amber-400' : 'bg-emerald-400' }} opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 {{ $booking->status == 'searching' ? 'bg-amber-500' : 'bg-emerald-500' }}"></span>
                            </span>
                            <span class="text-[11px] font-black uppercase tracking-widest">
                                {{ $booking->status == 'searching' ? 'Mencari Driver...' : 'Driver Ditemukan' }}
                            </span>
                        </div>
                        <span class="text-xs font-bold text-slate-400 tracking-tighter italic">{{ $booking->created_at->format('H:i') }} WIB</span>
                    </div>

                    <div class="space-y-4 mb-8">
                        <div class="flex items-start gap-4">
                            <div class="w-6 flex flex-col items-center">
                                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                <div class="w-0.5 h-10 bg-slate-100 my-1"></div>
                                <div class="w-2 h-2 rounded-full bg-slate-300"></div>
                            </div>
                            <div class="flex-1">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Titik Jemput</p>
                                <p class="text-sm font-bold text-slate-800 truncate">{{ $booking->pickup_point }}</p>
                                <div class="h-4"></div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Tujuan Akhir</p>
                                <p class="text-sm font-bold text-slate-800 truncate">{{ $booking->destination_point }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-3xl p-5 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-2xl shadow-sm">
                                {{ $booking->vehicle_type == 'motor' ? '🏍️' : '🚗' }}
                            </div>
                            <div>
                                <p class="text-[8px] font-black text-slate-400 uppercase">Estimasi Biaya</p>
                                <p class="text-xl font-black text-slate-900 italic tracking-tighter">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @if($booking->status == 'searching')
                            <button class="bg-red-50 text-red-500 px-5 py-3 rounded-2xl text-[10px] font-black uppercase tracking-tighter hover:bg-red-100 transition-colors">Batal</button>
                        @endif
                    </div>
                </div>
                @empty
                <div class="bg-slate-50 rounded-[40px] border-2 border-dashed border-slate-200 p-12 text-center">
                    <p class="text-4xl mb-4 text-slate-300">🤷‍♂️</p>
                    <p class="text-slate-400 font-bold italic">Belum ada aktivitas perjalanan nih.</p>
                </div>
                @endforelse
            </div>

            @if($historyBookings->count() > 0)
            <div>
                <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6">Riwayat Selesai</h2>
                <div class="space-y-4">
                    @foreach($historyBookings as $history)
                    <div class="flex items-center justify-between p-6 bg-white border border-slate-100 rounded-[30px] opacity-60">
                        <div class="flex items-center gap-4">
                            <span class="text-xl opacity-50">{{ $history->vehicle_type == 'motor' ? '🏍️' : '🚗' }}</span>
                            <div>
                                <p class="text-sm font-black text-slate-800">{{ $history->destination_point }}</p>
                                <p class="text-[10px] font-bold text-slate-400 italic">{{ $history->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        <p class="font-black text-slate-900 text-sm">Rp {{ number_format($history->total_price, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>