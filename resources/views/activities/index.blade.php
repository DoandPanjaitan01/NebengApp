<x-app-layout>
    @livewireStyles
    <div class="min-h-screen bg-slate-50 pb-32">
        <div class="max-w-xl mx-auto px-6 pt-12">
            
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tighter italic leading-none uppercase">Aktivitas Lo</h1>
                    <p class="text-slate-400 font-bold text-[10px] mt-2 italic tracking-widest uppercase">Pantau terus nebengan lo!</p>
                </div>
                <a href="{{ route('dashboard') }}" class="w-12 h-12 bg-white shadow-xl rounded-2xl flex items-center justify-center text-slate-900 hover:bg-slate-900 hover:text-white transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
            </div>

            <div class="mb-12">
                <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6 flex items-center gap-2">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span> Pesanan Berjalan
                </h2>
                
                {{-- Kita ambil bookings dari controller atau langsung panggil id-nya --}}
                @forelse($activeBookings as $active)
                    @livewire('booking-status', ['bookingId' => $active->id])
                @empty
                    <div class="bg-white rounded-[40px] border border-slate-100 p-12 text-center shadow-sm">
                        <p class="text-5xl mb-4">📭</p>
                        <p class="text-slate-400 font-bold italic">Lagi gak ada pesanan aktif.</p>
                        <a href="{{ route('bookings.create') }}" class="inline-block mt-4 text-emerald-500 font-black text-[10px] uppercase tracking-widest border-b-2 border-emerald-500 pb-1">Mulai Nebeng Sekarang →</a>
                    </div>
                @endforelse
            </div>

            @if(isset($historyBookings) && $historyBookings->count() > 0)
                <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6">Riwayat Selesai</h2>
                <div class="space-y-4">
                    @foreach($historyBookings as $history)
                        <div class="flex items-center justify-between p-6 bg-white border border-slate-50 rounded-[30px] shadow-sm opacity-70">
                            <div class="flex items-center gap-4">
                                <span class="text-2xl opacity-50">{{ $history->vehicle_type == 'motor' ? '🏍️' : '🚗' }}</span>
                                <div>
                                    <p class="text-sm font-black text-slate-800 leading-none mb-1">{{ Str::limit($history->destination_point, 20) }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">{{ $history->created_at->format('d M Y') }} • {{ strtoupper($history->status) }}</p>
                                </div>
                            </div>
                            <p class="font-black text-slate-900 text-sm italic">Rp{{ number_format($history->total_price, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
    @livewireScripts
</x-app-layout>