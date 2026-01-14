<x-app-layout>
    <div class="max-w-md mx-auto px-6 py-10 pb-32">
        <h1 class="text-3xl font-black text-slate-900 italic tracking-tighter uppercase mb-8">Aktivitas<span class="text-emerald-500">.</span></h1>

        @forelse($bookings as $booking)
            <div class="bg-white p-6 rounded-[30px] shadow-xl shadow-slate-200/50 border border-slate-50 mb-4 relative">
                <div class="absolute top-0 right-0 px-4 py-1 rounded-bl-xl text-[8px] font-black uppercase {{ $booking->status == 'pending' ? 'bg-amber-100 text-amber-600' : 'bg-emerald-100 text-emerald-600' }}">
                    {{ $booking->status }}
                </div>
                
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 bg-slate-900 rounded-xl flex items-center justify-center text-white text-xs font-bold">
                        {{ substr($booking->trip->driver->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-sm">{{ $booking->trip->driver->name }}</h3>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $booking->trip->origin }}</p>
                    </div>
                </div>

                <div class="space-y-2 border-l-2 border-dashed border-slate-100 ml-5 pl-5">
                    <p class="text-xs font-bold text-slate-700">Ke: {{ $booking->destination_point }}</p>
                    <p class="text-lg font-black text-emerald-600">Rp {{ number_format($booking->total_price) }}</p>
                </div>
            </div>
        @empty
            <p class="text-center text-slate-400 font-bold py-20">Belum ada aktivitas.</p>
        @endforelse
    </div>

    <x-bottom-nav />
</x-app-layout>