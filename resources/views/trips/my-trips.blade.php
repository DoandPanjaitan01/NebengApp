<x-app-layout>
    <div class="max-w-md mx-auto px-6 py-10 pb-32">
        <h1 class="text-2xl font-black text-slate-900 uppercase italic mb-8">Manajemen Tebengan 🛠️</h1>

        @forelse($myTrips as $trip)
            <div class="bg-white rounded-[30px] p-6 shadow-xl mb-6 border border-slate-100">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-[10px] font-black uppercase bg-slate-900 text-white px-3 py-1 rounded-full">
                        {{ $trip->vehicle_type }}
                    </span>
                    <span class="text-[10px] font-bold text-slate-400">{{ $trip->departure_time }}</span>
                </div>

                <h3 class="font-black text-slate-900">{{ $trip->origin }} ➔ {{ $trip->destination }}</h3>

                <div class="mt-6 space-y-4">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Pesanan Masuk:</p>
                    @forelse($trip->bookings as $booking)
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <div class="flex justify-between items-center mb-3">
                                <p class="font-bold text-sm text-slate-800">{{ $booking->user->name }}</p>
                                <span class="text-[8px] font-black uppercase px-2 py-1 rounded bg-amber-100 text-amber-600">{{ $booking->status }}</span>
                            </div>

                            @if($booking->status == 'pending')
                                <div class="flex gap-2">
                                    <form action="{{ route('bookings.accept', $booking->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button class="w-full py-2 bg-emerald-500 text-white text-[10px] font-black rounded-xl uppercase">Terima</button>
                                    </form>
                                    <form action="{{ route('bookings.reject', $booking->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button class="w-full py-2 bg-white text-red-500 border border-red-100 text-[10px] font-black rounded-xl uppercase">Tolak</button>
                                    </form>
                                </div>
                            @elseif($booking->status == 'confirmed')
                                <form action="{{ route('bookings.complete', $booking->id) }}" method="POST">
                                    @csrf
                                    <button class="w-full py-2 bg-slate-900 text-white text-[10px] font-black rounded-xl uppercase tracking-widest">Selesaikan Trip</button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <p class="text-[10px] text-slate-400 italic">Belum ada penumpang.</p>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="py-20 text-center border-2 border-dashed border-slate-200 rounded-[40px]">
                <p class="text-slate-400 font-bold uppercase text-xs">Lo belum buka rute tebengan.</p>
            </div>
        @endforelse
    </div>
    <x-bottom-nav />
</x-app-layout>