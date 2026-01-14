<x-app-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />

    <style>
        #map-arena { height: 100%; width: 100%; position: absolute; top: 0; left: 0; z-index: 1; }
        .hero-banner { background: #f8fafc; border-radius: 40px; border: 1px solid #f1f5f9; }
        .card-saldo { background: #0f172a; border-radius: 35px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
        /* SOLUSI: Padding bawah besar agar list tidak tertutup tombol/navbar */
        .content-safe-area { padding-bottom: 220px; } 
        [x-cloak] { display: none !important; }
    </style>

    <div x-data="rideFlow()" class="relative min-h-screen bg-white">
        
        <div x-show="step === 'home'" class="content-safe-area max-w-7xl mx-auto px-6 pt-10">
            
            <div class="hero-banner p-10 flex flex-col lg:flex-row justify-between items-center gap-10 mb-12">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="bg-emerald-500 text-white text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-tighter shadow-md">
                            {{ $stats['status_member'] }}
                        </span>
                        <span class="text-slate-400 text-[11px] font-bold">📍 {{ $stats['location'] }}</span>
                    </div>
                    <h1 class="text-5xl md:text-6xl font-black text-slate-900 tracking-tighter leading-none mb-4">
                        Halo, <span class="text-emerald-500">{{ explode(' ', $user->name)[0] }}!</span> 🚀
                    </h1>
                    <p class="text-slate-500 text-base font-medium">Siap berangkat hari ini? Tentukan rute amanmu sekarang.</p>
                </div>

                <div class="card-saldo p-8 w-full lg:w-[380px] text-white">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <p class="text-[9px] font-black text-emerald-400 uppercase tracking-widest">Total Saldo Lo</p>
                            <p class="text-3xl font-black italic tracking-tighter">Rp {{ $stats['balance'] }}</p>
                        </div>
                        <div class="bg-white/10 p-3 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <button class="bg-emerald-500 text-slate-900 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-emerald-400 transition-all">TOP UP</button>
                        <button class="bg-white/10 text-white py-3 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-white/20 transition-all">RIWAYAT</button>
                    </div>
                </div>
            </div>

            <div class="px-2">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-black text-slate-900 tracking-tighter flex items-center gap-3">
                        <span class="w-2 h-7 bg-emerald-500 rounded-full"></span>
                        Tebengan Tersedia
                    </h2>
                    <button class="bg-slate-900 text-white px-6 py-3 rounded-2xl font-black text-[9px] uppercase tracking-widest">
                        + BUKA JASA
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($nearbyRides as $ride)
                    <div class="bg-white p-6 rounded-[35px] border border-slate-100 shadow-sm flex items-center justify-between hover:shadow-lg transition-all group cursor-pointer">
                        <div class="flex items-center gap-5">
                            <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-emerald-50 transition-colors">
                                {{ $ride['type'] == 'motor' ? '🏍️' : '🚗' }}
                            </div>
                            <div>
                                <h4 class="text-base font-black text-slate-900 leading-tight">{{ $ride['driver'] }}</h4>
                                <span class="text-[8px] font-black text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-md uppercase">{{ $ride['status'] }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-black text-slate-900 italic">Rp {{ $ride['rate'] }}</p>
                            <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">PER KM</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="fixed bottom-28 left-0 right-0 flex justify-center z-[50]">
                <button @click="startBooking()" class="bg-emerald-500 text-slate-900 px-12 py-5 rounded-full font-black text-xs uppercase tracking-[0.3em] shadow-[0_15px_40px_rgba(16,185,129,0.3)] hover:scale-105 active:scale-95 transition-all">
                    MULAI NEBENG SEKARANG
                </button>
            </div>
        </div>

        <div x-show="step === 'booking'" x-cloak class="fixed inset-0 z-[100] bg-white flex flex-col">
            <div id="map-arena"></div>
            
            <div class="absolute top-8 left-0 right-0 z-[110] px-6">
                <div class="max-w-xl mx-auto flex items-center justify-between">
                    <button @click="step = 'home'" class="w-14 h-14 bg-white rounded-full shadow-2xl flex items-center justify-center text-slate-900 border border-slate-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="4"><path d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <div class="bg-slate-900 px-8 py-3 rounded-full shadow-2xl border border-white/10">
                        <p class="text-[10px] font-black text-white uppercase tracking-widest">Tap 2x di Map untuk Rute</p>
                    </div>
                    <div class="w-14"></div>
                </div>
            </div>

            <div class="absolute bottom-10 left-0 right-0 z-[110] px-6">
                <div class="max-w-2xl mx-auto bg-white rounded-[50px] shadow-[0_-20px_80px_rgba(15,23,42,0.25)] p-10">
                    <form action="{{ route('trips.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="distance" x-model="distance">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <input type="text" name="pickup_name" x-model="pickupName" readonly class="bg-slate-50 border-none p-5 rounded-2xl font-black text-xs" placeholder="Titik Jemput">
                            <input type="text" name="dest_name" x-model="destName" readonly class="bg-slate-50 border-none p-5 rounded-2xl font-black text-xs" placeholder="Titik Tujuan">
                        </div>

                        <div class="grid grid-cols-3 gap-4 mb-8">
                            <template x-for="v in vehicles">
                                <label class="cursor-pointer">
                                    <input type="radio" name="vehicle_type" :value="v.id" x-model="vType" class="hidden peer">
                                    <div class="peer-checked:bg-slate-900 peer-checked:text-white bg-slate-50 p-5 rounded-[30px] text-center transition-all">
                                        <span class="text-2xl block mb-1" x-text="v.icon"></span>
                                        <p class="text-[9px] font-black uppercase tracking-tighter" x-text="v.name"></p>
                                    </div>
                                </label>
                            </template>
                        </div>

                        <div class="flex justify-between items-end mb-8">
                            <div class="text-left">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Bayar via</p>
                                <select name="payment_method" class="bg-transparent border-none font-black text-sm p-0 focus:ring-0">
                                    <option value="nebengpay">NebengPay</option>
                                    <option value="cash">Tunai</option>
                                </select>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-black text-emerald-500 italic mb-1" x-text="distance ? distance + ' KM' : '---'"></p>
                                <p class="text-4xl font-black text-slate-900 tracking-tighter">Rp <span x-text="totalPrice.toLocaleString('id-ID')"></span></p>
                            </div>
                        </div>

                        <button type="submit" :disabled="!distance" class="w-full bg-emerald-500 disabled:bg-slate-200 text-white py-8 rounded-full font-black text-xs uppercase tracking-[0.4em] shadow-2xl transition-all active:scale-95">KONFIRMASI PESANAN</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <script>
        function rideFlow() {
            return {
                step: 'home',
                vType: 'motor',
                distance: 0,
                pickupName: '', destName: '',
                pickupCoord: null, destCoord: null,
                map: null, routing: null,
                vehicles: [
                    {id: 'motor', name: 'MOTOR', icon: '🏍️', rate: 3000},
                    {id: 'mobil_l', name: 'MOBIL L', icon: '🚗', rate: 6000},
                    {id: 'mobil_xl', name: 'MOBIL XL', icon: '🚐', rate: 10000}
                ],
                get totalPrice() {
                    const v = this.vehicles.find(v => v.id === this.vType);
                    return Math.ceil(this.distance * v.rate);
                },
                startBooking() {
                    this.step = 'booking';
                    this.$nextTick(() => this.initMap());
                },
                initMap() {
                    if (this.map) return;
                    this.map = L.map('map-arena', { zoomControl: false }).setView([-6.2088, 106.8456], 14);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(this.map);

                    this.map.on('click', (e) => {
                        if (!this.pickupCoord) {
                            this.pickupCoord = e.latlng;
                            this.pickupName = "Jemput di Titik Ini";
                            L.marker(e.latlng).addTo(this.map).bindPopup("Titik Jemput").openPopup();
                        } else if (!this.destCoord) {
                            this.destCoord = e.latlng;
                            this.destName = "Antar ke Titik Ini";
                            L.marker(e.latlng).addTo(this.map).bindPopup("Titik Tujuan").openPopup();
                            
                            this.routing = L.Routing.control({
                                waypoints: [this.pickupCoord, this.destCoord],
                                lineOptions: { styles: [{ color: '#10b981', weight: 8, opacity: 0.8 }] },
                                createMarker: () => null,
                                addWaypoints: false
                            }).on('routesfound', (ev) => {
                                this.distance = (ev.routes[0].summary.totalDistance / 1000).toFixed(1);
                            }).addTo(this.map);
                        }
                    });
                }
            }
        }
    </script>
</x-app-layout>