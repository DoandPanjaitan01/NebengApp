<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Detail #{{ $booking->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        #chat-container::-webkit-scrollbar { width: 4px; }
        #chat-container::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
        .bubble-me::after {
            content: ''; position: absolute; bottom: 0; right: -8px;
            width: 15px; height: 15px; background: #16a34a;
            clip-path: polygon(0 0, 0% 100%, 100% 100%);
        }
        .bubble-other::after {
            content: ''; position: absolute; bottom: 0; left: -8px;
            width: 15px; height: 15px; background: white;
            clip-path: polygon(100% 0, 0 100%, 100% 100%);
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-900">

<div class="max-w-md mx-auto bg-white min-h-screen shadow-[0_0_50px_rgba(0,0,0,0.1)] flex flex-col relative">
    
    <div class="sticky top-0 z-20 bg-white/90 backdrop-blur-xl px-6 py-4 flex items-center justify-between border-b border-slate-100">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="group w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 hover:bg-green-600 transition-all duration-300">
                <i class="fas fa-chevron-left text-slate-500 group-hover:text-white"></i>
            </a>
            <div>
                <h1 class="font-extrabold text-slate-800 tracking-tight text-lg">Detail Trip</h1>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">ID-{{ $booking->id }}</p>
                </div>
            </div>
        </div>
        <span class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-extrabold rounded-full uppercase tracking-tighter">On Process</span>
    </div>

    <div class="p-6 pb-2">
        <div class="bg-slate-900 rounded-[2rem] p-5 text-white shadow-2xl shadow-slate-300 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:bg-green-500/20 transition-all"></div>
            <div class="flex items-center gap-4 relative z-10">
                <div class="relative">
                    <img src="{{ $driverData['photo'] }}" class="w-16 h-16 rounded-2xl border-2 border-white/20 object-cover shadow-lg">
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 border-4 border-slate-900 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-[8px] text-white"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <h2 class="font-bold text-lg tracking-tight">{{ $driverData['name'] }}</h2>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="px-2 py-0.5 bg-white/10 rounded text-[10px] font-medium text-slate-300">{{ $driverData['plate'] }}</span>
                        <div class="flex items-center gap-1">
                            <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                            <span class="text-[11px] font-bold">{{ $driverData['rating'] }}</span>
                        </div>
                    </div>
                </div>
                <a href="tel:#" class="w-11 h-11 bg-white/10 hover:bg-green-500 rounded-2xl flex items-center justify-center transition-all">
                    <i class="fas fa-phone-alt text-sm"></i>
                </a>
            </div>

            <div class="mt-5 pt-5 border-t border-white/10 grid grid-cols-2 gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/5 rounded-xl flex items-center justify-center text-green-400">
                        <i class="fas {{ $driverData['icon'] ?? 'fa-car' }}"></i>
                    </div>
                    <div>
                        <p class="text-[9px] text-slate-400 font-bold uppercase">Kendaraan</p>
                        <p class="text-xs font-semibold">{{ $driverData['vehicle_name'] }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/5 rounded-xl flex items-center justify-center text-blue-400">
                        <i class="fas fa-palette"></i>
                    </div>
                    <div>
                        <p class="text-[9px] text-slate-400 font-bold uppercase">Warna</p>
                        <p class="text-xs font-semibold">{{ $driverData['vehicle_color'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="p-6 space-y-5">
        <div class="bg-slate-50 rounded-3xl p-5 border border-slate-100">
            <div class="relative pl-7 space-y-6">
                <div class="absolute left-[11px] top-2 bottom-2 w-[2px] border-l-2 border-dashed border-slate-200"></div>
                
                <div class="relative">
                    <div class="absolute -left-[24px] top-1 w-4 h-4 bg-blue-500 rounded-full border-4 border-white shadow-md"></div>
                    <label class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1">Pickup Point</label>
                    <p class="text-sm font-bold text-slate-700 leading-snug">{{ $booking->pickup_point }}</p>
                </div>

                <div class="relative">
                    <div class="absolute -left-[24px] top-1 w-4 h-4 bg-red-500 rounded-full border-4 border-white shadow-md"></div>
                    <label class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1">Destination</label>
                    <p class="text-sm font-bold text-slate-700 leading-snug">{{ $booking->destination_point }}</p>
                </div>
            </div>
            
            <div class="mt-5 pt-5 border-t border-slate-200 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center text-green-600 text-xs">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div>
                        <p class="text-[8px] text-slate-400 font-extrabold uppercase leading-none">{{ $booking->payment_method }}</p>
                        <p class="text-xs font-bold text-slate-800">Payment</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-[8px] text-slate-400 font-extrabold uppercase leading-none">Total Fare</p>
                    <p class="text-lg font-black text-green-600 tracking-tighter">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-auto flex-1 flex flex-col bg-slate-50 rounded-t-[2.5rem] border-t border-slate-200 shadow-[0_-10px_40px_rgba(0,0,0,0.03)] overflow-hidden">
        <div id="chat-container" class="flex-1 overflow-y-auto p-6 space-y-6">
            @forelse($booking->messages as $msg)
                <div class="flex {{ $msg->sender_id == Auth::id() ? 'justify-end' : 'justify-start' }} animate-fade-in">
                    <div class="relative px-5 py-3 shadow-md {{ $msg->sender_id == Auth::id() ? 'bg-green-600 text-white rounded-l-2xl rounded-tr-2xl bubble-me' : 'bg-white text-slate-800 rounded-r-2xl rounded-tl-2xl border border-slate-100 bubble-other' }}">
                        <p class="text-sm font-medium leading-relaxed">{{ $msg->message }}</p>
                        <div class="flex items-center justify-end gap-1 mt-1 opacity-60">
                            <span class="text-[9px] font-bold">{{ $msg->created_at->format('H:i') }}</span>
                            @if($msg->sender_id == Auth::id())
                                <i class="fas fa-check-double text-[8px]"></i>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="h-full flex flex-col items-center justify-center opacity-20 py-10">
                    <i class="fas fa-comment-dots text-5xl mb-4"></i>
                    <p class="font-bold text-sm">Awali percakapan dengan driver</p>
                </div>
            @endforelse
        </div>

        <div class="p-5 bg-white border-t border-slate-100">
            <div class="flex items-center gap-3 bg-slate-100 rounded-[1.5rem] p-1.5 focus-within:bg-white focus-within:ring-2 focus-within:ring-green-500/20 transition-all duration-300 border border-transparent focus-within:border-green-500 shadow-inner">
                <input type="text" id="message-input" 
                    class="bg-transparent flex-1 px-4 py-2 outline-none text-sm font-medium text-slate-700" 
                    placeholder="Ketik pesan..."
                    onkeypress="if(event.key === 'Enter') sendChat()">
                <button onclick="sendChat()" class="w-11 h-11 bg-green-600 text-white rounded-2xl hover:bg-green-700 transition-all flex items-center justify-center shadow-lg shadow-green-100 active:scale-95">
                    <i class="fas fa-paper-plane text-sm"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const container = document.getElementById('chat-container');
    function scrollToBottom() { container.scrollTop = container.scrollHeight; }
    window.onload = scrollToBottom;

    function sendChat() {
        const input = document.getElementById('message-input');
        const msg = input.value.trim();
        if(!msg) return;

        fetch("/bookings/{{ $booking->id }}/send-message", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: JSON.stringify({ message: msg })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                const html = `
                    <div class="flex justify-end">
                        <div class="relative px-5 py-3 shadow-md bg-green-600 text-white rounded-l-2xl rounded-tr-2xl bubble-me">
                            <p class="text-sm font-medium leading-relaxed">${data.message}</p>
                            <div class="flex items-center justify-end gap-1 mt-1 opacity-60">
                                <span class="text-[9px] font-bold">${data.time}</span>
                                <i class="fas fa-check-double text-[8px]"></i>
                            </div>
                        </div>
                    </div>`;
                container.insertAdjacentHTML('beforeend', html);
                input.value = '';
                scrollToBottom();
            }
        });
    }
</script>
</body>
</html>