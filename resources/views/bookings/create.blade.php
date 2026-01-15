<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NebengApp - Official Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        #map { height: 100%; width: 100%; z-index: 10; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        
        /* Suggestion Box Styles */
        .suggestion-box { 
            position: absolute; width: 100%; background: white; z-index: 9999; 
            border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); 
            top: 100%; margin-top: 8px; border: 1px solid #f1f5f9; overflow: hidden;
        }
        .suggestion-item { padding: 14px 20px; cursor: pointer; border-bottom: 1px solid #f8fafc; font-size: 13px; font-weight: 600; color: #475569; }
        .suggestion-item:hover { background: #f0fdf4; color: #10B981; }

        .vehicle-card.active { border-color: #10B981; background-color: #f0fdf4; transform: scale(1.01); }
        .leaflet-routing-container { display: none !important; }

        .custom-pin { width: 24px; height: 24px; border-radius: 50% 50% 50% 0; position: absolute; transform: rotate(-45deg); left: 50%; top: 50%; margin: -12px 0 0 -12px; border: 3px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.2); }
        .marker-label { position: absolute; top: -35px; left: 50%; transform: translateX(-50%); background: white; padding: 4px 10px; border-radius: 8px; font-size: 10px; font-weight: 800; white-space: nowrap; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border: 1px solid #eee; z-index: 1000; }
        
        #payment_modal { display: none; }
        #payment_modal.active { display: flex; }

        @keyframes slide-up {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }
        .animate-slide-up { animation: slide-up 0.3s ease-out; }

        /* --- LOGIC BARU: RADAR ANIMATION --- */
        #finding_driver_overlay { display: none; }
        #finding_driver_overlay.active { display: flex; z-index: 20000; }

        .radar {
            position: relative;
            width: 150px;
            height: 150px;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 50%;
            border: 2px solid #10B981;
        }
        .radar:before {
            content: "";
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 10px; height: 10px;
            background: #10B981;
            border-radius: 50%;
            box-shadow: 0 0 20px #10B981;
        }
        .pulse {
            position: absolute;
            width: 100%; height: 100%;
            border: 2px solid #10B981;
            border-radius: 50%;
            animation: pulsing 2s linear infinite;
        }
        @keyframes pulsing {
            0% { transform: scale(0.5); opacity: 1; }
            100% { transform: scale(2.5); opacity: 0; }
        }
    </style>
</head>
<body class="h-screen overflow-hidden">

    <div id="finding_driver_overlay" class="fixed inset-0 bg-white flex flex-col items-center justify-center p-8 text-center">
        <div class="radar mb-12">
            <div class="pulse"></div>
            <div class="pulse" style="animation-delay: 0.5s"></div>
            <div class="pulse" style="animation-delay: 1s"></div>
        </div>
        
        <h2 class="text-2xl font-800 text-slate-900 mb-2 tracking-tight">Mencari Driver...</h2>
        <p class="text-slate-500 font-bold text-sm max-w-xs mb-10">Sabar ya bro, lagi nyariin driver <span id="display_vehicle_name" class="text-emerald-500">NebengRide</span> terdekat.</p>
        
        <div class="w-full max-w-xs space-y-4">
            <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm text-lg">📍</div>
                <div class="text-left overflow-hidden">
                    <p class="text-[9px] font-800 text-slate-400 uppercase">Jemput Di</p>
                    <p id="confirm_pickup_label" class="text-xs font-bold text-slate-800 truncate w-full">--</p>
                </div>
            </div>
            
            <button type="button" onclick="location.reload()" class="w-full py-4 text-red-500 font-800 text-[10px] uppercase tracking-widest hover:bg-red-50 rounded-xl transition-all">Batalkan Pencarian</button>
        </div>
    </div>

    <div id="payment_modal" class="fixed inset-0 z-[10000] items-end justify-center bg-black/50 backdrop-blur-sm">
        <div class="w-full max-w-md bg-white rounded-t-[32px] p-8 animate-slide-up">
            <div class="w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-6"></div>
            <h3 class="text-xl font-800 text-slate-900 mb-6">Pilih Pembayaran</h3>
            <div class="space-y-4">
                <button type="button" onclick="setPayment('NebengPay', 'bg-blue-600', 'nebengpay')" class="w-full flex items-center justify-between p-4 rounded-2xl border-2 border-slate-100 hover:border-blue-500 transition-all group">
                    <div class="flex items-center gap-4">
                        <div class="bg-blue-600 p-2 rounded-lg text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                        </div>
                        <span class="font-bold text-slate-700">NebengPay</span>
                    </div>
                </button>
                <button type="button" onclick="setPayment('Tunai', 'bg-green-600', 'cash')" class="w-full flex items-center justify-between p-4 rounded-2xl border-2 border-slate-100 hover:border-green-500 transition-all group">
                    <div class="flex items-center gap-4">
                        <div class="bg-green-600 p-2 rounded-lg text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" /></svg>
                        </div>
                        <span class="font-bold text-slate-700">Tunai</span>
                    </div>
                </button>
            </div>
            <button type="button" onclick="closePaymentModal()" class="w-full mt-6 py-4 text-slate-400 font-bold text-sm">Batal</button>
        </div>
    </div>

    <div class="flex h-full">
        <div class="hidden lg:block lg:w-3/5 xl:w-2/3 relative bg-slate-200">
            <div id="map"></div>
            <a href="{{ route('dashboard') }}" class="absolute top-6 left-6 z-[1000] bg-white p-4 rounded-2xl shadow-xl hover:bg-gray-50 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        </div>

        <div class="w-full lg:w-2/5 xl:w-1/3 bg-white h-full shadow-2xl z-20 overflow-y-auto no-scrollbar flex flex-col">
            <div class="p-8 flex-1">
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-2xl font-800 text-slate-900 tracking-tight">Konfirmasi Pesanan</h1>
                    <div class="px-3 py-1 bg-green-50 rounded-full border border-green-100 uppercase text-[10px] font-800 text-green-600 tracking-widest">Nebeng Segera</div>
                </div>

                <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm" onsubmit="handleBookingSubmit(event)">
                    @csrf
                    <input type="hidden" name="payment_method" id="input_payment_method" value="nebengpay">
                    <input type="hidden" name="vehicle_type" id="selected_type" value="motor">
                    <input type="hidden" name="total_price" id="final_price_input">
                    <input type="hidden" name="distance" id="final_distance_input">

                    <div class="bg-slate-50 rounded-[32px] p-6 border border-slate-100 mb-6">
                        <div class="space-y-6">
                            <div class="relative group">
                                <div class="flex items-center gap-4">
                                    <div class="w-2.5 h-2.5 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.5)]"></div>
                                    <div class="flex-1">
                                        <label class="text-[10px] font-800 text-slate-400 uppercase tracking-widest mb-1 block">Titik Penjemputan</label>
                                        <input type="text" id="pickup_input" name="pickup_name" placeholder="Lokasi jemput..." class="w-full bg-transparent font-bold text-slate-800 focus:outline-none text-sm border-b border-slate-200 pb-2 group-focus-within:border-blue-400 transition-colors" autocomplete="off" required>
                                    </div>
                                </div>
                                <div id="pickup_results" class="suggestion-box hidden"></div>
                            </div>

                            <div class="relative group">
                                <div class="flex items-center gap-4">
                                    <div class="w-2.5 h-2.5 rounded-full bg-orange-500 shadow-[0_0_10px_rgba(249,115,22,0.5)]"></div>
                                    <div class="flex-1">
                                        <label class="text-[10px] font-800 text-slate-400 uppercase tracking-widest mb-1 block">Tujuan Akhir</label>
                                        <input type="text" id="dest_input" name="dest_name" placeholder="Lokasi tujuan..." class="w-full bg-transparent font-bold text-slate-800 focus:outline-none text-sm border-b border-slate-200 pb-2 group-focus-within:border-orange-400 transition-colors" autocomplete="off" required>
                                    </div>
                                </div>
                                <div id="dest_results" class="suggestion-box hidden"></div>
                            </div>
                        </div>
                    </div>

                    <div id="vehicle_section" class="space-y-3 mb-6 opacity-40 pointer-events-none transition-all duration-700">
                        <div class="flex items-center justify-between px-1 mb-4">
                            <h3 class="text-xs font-800 text-slate-400 uppercase tracking-widest">Layanan Nebeng</h3>
                            <span id="dist_label" class="text-[10px] font-900 text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md">-- KM</span>
                        </div>
                        
                        @php
                            $options = [
                                ['id' => 'motor', 'name' => 'NebengRide', 'sub' => 'CEPAT & EKONOMIS', 'icon' => '🛵', 'rate' => 3000, 'cap' => '1 Kursi'],
                                ['id' => 'mobil_l', 'name' => 'NebengCar', 'sub' => 'NYAMAN BER-AC', 'icon' => '🚗', 'rate' => 6000, 'cap' => '4 Kursi'],
                                ['id' => 'mobil_xl', 'name' => 'NebengCar XL', 'sub' => 'KAPASITAS BESAR', 'icon' => '🚐', 'rate' => 10000, 'cap' => '6 Kursi']
                            ];
                        @endphp

                        @foreach($options as $opt)
                        <div class="vehicle-card border-2 border-slate-100 p-4 rounded-[24px] flex items-center justify-between cursor-pointer transition-all {{ $loop->first ? 'active' : '' }}" onclick="selectVehicle('{{ $opt['id'] }}', {{ $opt['rate'] }}, this, '{{ $opt['name'] }}')">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-xl shadow-sm border border-slate-50">{{ $opt['icon'] }}</div>
                                <div>
                                    <p class="font-800 text-xs text-slate-900">{{ $opt['name'] }}</p>
                                    <p class="text-[9px] text-slate-400 font-bold tracking-tight">{{ $opt['sub'] }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-900 text-green-600 text-sm v-price">-</p>
                                <p class="text-[8px] text-slate-300 font-bold uppercase">{{ $opt['cap'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mb-8 p-4 bg-slate-900 rounded-2xl flex items-center justify-between border border-slate-800 shadow-lg">
                        <div class="flex items-center gap-3">
                            <div id="payment_icon_container" class="bg-blue-600 p-2 rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-800 text-slate-500 uppercase">Metode Pembayaran</p>
                                <p id="payment_text_display" class="text-xs font-bold text-white tracking-wide">NebengPay</p>
                            </div>
                        </div>
                        <button type="button" onclick="openPaymentModal()" class="text-[10px] font-900 text-blue-400 hover:text-blue-300 uppercase tracking-widest">Ubah</button>
                    </div>

                    <div class="space-y-4">
                        <button type="submit" id="btn_submit" disabled class="w-full bg-slate-200 text-white p-5 rounded-[24px] font-800 flex justify-between items-center transition-all cursor-not-allowed group shadow-xl">
                            <span class="text-sm uppercase tracking-wider" id="btn_text">Tentukan Rute</span>
                            <div class="flex items-center gap-2">
                                <span id="footer_price" class="text-lg font-900 tracking-tighter">Rp0</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                            </div>
                        </button>
                        
                        <a href="{{ route('dashboard') }}" class="w-full py-4 block text-center text-slate-400 font-800 text-[10px] uppercase tracking-[0.2em] hover:text-red-500 transition-colors">
                            Batalkan Pesanan
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <script>
        const map = L.map('map', { zoomControl: false }).setView([3.5952, 98.6722], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        let pickupCoords = null;
        let destCoords = null;
        let routingControl = null;
        let currentDist = 0;

        /* --- LOGIC SUBMIT AJAX (DITAMBAHKAN) --- */
        async function handleBookingSubmit(e) {
            e.preventDefault(); // Cegah halaman refresh!
            
            const form = e.target;
            const formData = new FormData(form);

            // Update UI Overlay sebelum dikirim
            const vehicleName = document.querySelector('.vehicle-card.active p.font-800').innerText;
            document.getElementById('display_vehicle_name').innerText = vehicleName;
            document.getElementById('confirm_pickup_label').innerText = document.getElementById('pickup_input').value;
            
            // Tampilkan Overlay Radar
            document.getElementById('finding_driver_overlay').classList.add('active');

            // Kirim ke Laravel
            try {
                const response = await fetch(form.action, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                });

                if (response.ok) {
                    console.log("Pesanan berhasil dibuat di database!");
                    // Simulasi mencari selama 5 detik
                    setTimeout(() => {
                        alert("Berhasil! Driver sedang menuju ke lokasi Anda.");
                        window.location.href = "{{ route('dashboard') }}";
                    }, 5000);
                } else {
                    alert("Gagal membuat pesanan. Coba lagi.");
                    document.getElementById('finding_driver_overlay').classList.remove('active');
                }
            } catch (error) {
                console.error("Error:", error);
                document.getElementById('finding_driver_overlay').classList.remove('active');
            }
        }

        // FUNGSI PEMBAYARAN
        function openPaymentModal() {
            document.getElementById('payment_modal').classList.add('active');
        }

        function closePaymentModal() {
            document.getElementById('payment_modal').classList.remove('active');
        }

        function setPayment(methodLabel, colorClass, dbValue) {
            document.getElementById('payment_text_display').innerText = methodLabel;
            const iconCont = document.getElementById('payment_icon_container');
            iconCont.className = `${colorClass} p-2 rounded-lg transition-colors`;
            document.getElementById('input_payment_method').value = dbValue;
            closePaymentModal();
        }

        function createIcon(color, label) {
            return L.divIcon({
                className: 'custom-icon',
                html: `<div style="position:relative">
                        <div class="marker-label">${label}</div>
                        <div class="custom-pin" style="background:${color}"></div>
                       </div>`,
                iconSize: [24, 24],
                iconAnchor: [12, 24]
            });
        }

        function handleSearch(inputId, resultsId, type) {
            const input = document.getElementById(inputId);
            const results = document.getElementById(resultsId);

            input.addEventListener('input', function() {
                if (this.value.length < 3) { results.classList.add('hidden'); return; }
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${this.value}&countrycodes=id`)
                    .then(res => res.json()).then(data => {
                        results.innerHTML = '';
                        results.classList.remove('hidden');
                        data.slice(0, 4).forEach(item => {
                            const div = document.createElement('div');
                            div.className = 'suggestion-item';
                            div.innerText = item.display_name.split(',').slice(0, 2).join(', ');
                            div.addEventListener('mousedown', (e) => {
                                e.preventDefault();
                                input.value = item.display_name.split(',')[0];
                                results.classList.add('hidden');
                                if (type === 'pickup') pickupCoords = [item.lat, item.lon];
                                else destCoords = [item.lat, item.lon];
                                drawRoute();
                            });
                            results.appendChild(div);
                        });
                    });
            });
            input.addEventListener('blur', () => setTimeout(() => results.classList.add('hidden'), 200));
        }

        handleSearch('pickup_input', 'pickup_results', 'pickup');
        handleSearch('dest_input', 'dest_results', 'dest');

        function drawRoute() {
            if (!pickupCoords || !destCoords) return;
            if (routingControl) map.removeControl(routingControl);

            routingControl = L.Routing.control({
                waypoints: [L.latLng(pickupCoords), L.latLng(destCoords)],
                show: false,
                addWaypoints: false,
                draggableWaypoints: false,
                lineOptions: { styles: [{ color: '#10B981', weight: 8, opacity: 0.7 }] },
                createMarker: function(i, wp) {
                    const color = (i === 0) ? '#3b82f6' : '#f97316';
                    const label = (i === 0) ? 'PENJEMPUTAN' : 'TUJUAN';
                    return L.marker(wp.latLng, { icon: createIcon(color, label) });
                }
            }).on('routesfound', function(e) {
                const route = e.routes[0];
                currentDist = route.summary.totalDistance / 1000;
                document.getElementById('dist_label').innerText = currentDist.toFixed(1) + ' KM';
                document.getElementById('final_distance_input').value = currentDist.toFixed(2);
                
                calculatePrices(currentDist);
                
                document.getElementById('vehicle_section').classList.remove('opacity-40', 'pointer-events-none');
                const btn = document.getElementById('btn_submit');
                btn.disabled = false;
                btn.className = "w-full bg-[#10B981] text-white p-5 rounded-[24px] font-800 flex justify-between items-center shadow-2xl hover:brightness-110 transition-all";
                
                const currentName = document.querySelector('.vehicle-card.active p.font-800').innerText;
                document.getElementById('btn_text').innerText = "Konfirmasi " + currentName;
            }).addTo(map);
        }

        function calculatePrices(dist) {
            const rates = [3000, 6000, 10000];
            const priceElements = document.querySelectorAll('.v-price');
            priceElements.forEach((el, idx) => {
                const total = Math.ceil(dist * rates[idx]);
                el.innerText = 'Rp' + total.toLocaleString('id-ID');
                if (idx === 0) updateFooter(total); 
            });
        }

        function selectVehicle(type, rate, el, name) {
            document.querySelectorAll('.vehicle-card').forEach(c => c.classList.remove('active'));
            el.classList.add('active');
            const total = Math.ceil(currentDist * rate);
            document.getElementById('selected_type').value = type;
            document.getElementById('btn_text').innerText = `Konfirmasi ${name}`;
            updateFooter(total);
        }

        function updateFooter(price) {
            document.getElementById('footer_price').innerText = 'Rp' + price.toLocaleString('id-ID');
            document.getElementById('final_price_input').value = price;
        }
    </script>
</body>
</html>