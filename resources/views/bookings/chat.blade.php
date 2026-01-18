<x-app-layout>
    <div class="max-w-md mx-auto h-screen flex flex-col bg-white border-x border-slate-100 shadow-2xl relative pb-40">
        
        <div class="p-6 bg-white border-b border-slate-100 flex items-center justify-between sticky top-0 z-50">
            <div class="flex items-center gap-4">
                <a href="{{ route('bookings.show', $booking->id) }}" class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center transition active:scale-90">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="3" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-emerald-500 rounded-2xl flex items-center justify-center text-white font-black text-lg shadow-lg shadow-emerald-100">
                        {{ substr($driverData['name'] ?? 'D', 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm leading-tight">{{ $driverData['name'] ?? 'Driver' }}</h3>
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                            <p class="text-[10px] font-black text-emerald-500 tracking-widest uppercase italic">Sedang Menuju Lokasi</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Order ID</p>
                <p class="text-xs font-black text-slate-900 italic">#NBG-{{ $booking->id }}</p>
            </div>
        </div>

        <div class="px-6 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2 overflow-hidden">
                <span class="text-lg">📍</span>
                <p class="text-[10px] font-bold text-slate-500 truncate italic">Ke: {{ $booking->destination_point }}</p>
            </div>
            <div class="flex items-center gap-1 bg-white px-2 py-1 rounded-lg border border-slate-200">
                <span class="text-[9px] font-black text-slate-600">{{ $driverData['plate'] ?? 'BK 0000 XX' }}</span>
            </div>
        </div>

        <div id="chat-container" class="flex-1 overflow-y-auto p-6 space-y-6 bg-[#fcfdfe]">
            @forelse($booking->messages as $msg)
                <div class="flex {{ $msg->sender_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[85%]">
                        <div class="p-4 rounded-[24px] shadow-sm {{ $msg->sender_id == Auth::id() 
                            ? 'bg-emerald-500 text-white rounded-tr-none shadow-emerald-100' 
                            : 'bg-white text-slate-800 rounded-tl-none border border-slate-100' }}">
                            <p class="text-[13px] font-medium leading-relaxed">{{ $msg->message }}</p>
                        </div>
                        <p class="text-[9px] mt-1.5 font-bold text-slate-400 px-1 {{ $msg->sender_id == Auth::id() ? 'text-right' : 'text-left' }}">
                            {{ $msg->created_at->format('H:i') }} • {{ $msg->sender_id == Auth::id() ? 'Terkirim' : 'Driver' }}
                        </p>
                    </div>
                </div>
            @empty
                <div id="empty-state" class="flex flex-col items-center justify-center h-full opacity-30 italic">
                    <p class="text-sm font-bold text-slate-400">Belum ada obrolan. Sapa Drivermu! 👋</p>
                </div>
            @endforelse
            <div id="anchor"></div>
        </div>

        <div class="fixed bottom-0 left-0 right-0 px-6 pb-28 z-[60] pointer-events-none">
            <div class="max-w-md mx-auto pointer-events-auto">
                <form id="chat-form" class="flex items-center gap-3 bg-white p-2 rounded-[32px] shadow-2xl border border-slate-100 focus-within:ring-2 focus-within:ring-emerald-500/10 transition-all">
                    @csrf
                    <button type="button" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-emerald-500 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </button>
                    <input type="text" id="chat-input" autocomplete="off" placeholder="Kirim pesan ke driver..." 
                        class="flex-1 bg-transparent border-none focus:ring-0 text-sm font-bold text-slate-700 placeholder:text-slate-400 py-3">
                    <button type="submit" class="w-11 h-11 bg-emerald-500 text-white rounded-full flex items-center justify-center shadow-lg transition active:scale-90">
                        <svg class="w-5 h-5 transform rotate-90" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const chatContainer = document.getElementById('chat-container');

        // Scroll otomatis ke bawah
        chatContainer.scrollTop = chatContainer.scrollHeight;

        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = chatInput.value.trim();
            if (!message) return;

            // 1. Generate ID unik sementara buat bubble ini
            const tempId = 'msg-' + Date.now();
            const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            // 2. Optimistic UI
            appendMessage(message, time, tempId);
            chatInput.value = '';
            
            const emptyState = document.getElementById('empty-state');
            if(emptyState) emptyState.remove();

            try {
                const response = await fetch("{{ route('bookings.sendMessage', $booking->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: message })
                });

                const data = await response.json();
                
                // 3. Update status dari 'Mengirim' ke 'Terkirim' setelah respon sukses
                if (data.success) {
                    const statusElement = document.getElementById('status-' + tempId);
                    if(statusElement) statusElement.innerText = 'Terkirim';
                } else {
                    document.getElementById('status-' + tempId).innerText = 'Gagal';
                    document.getElementById('status-' + tempId).classList.add('text-red-500');
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('status-' + tempId).innerText = 'Error Koneksi';
            }
        });

        function appendMessage(text, time, id) {
            const msgHtml = `
                <div class="flex justify-end">
                    <div class="max-w-[85%]">
                        <div class="p-4 rounded-[24px] bg-emerald-500 text-white rounded-tr-none shadow-lg shadow-emerald-100">
                            <p class="text-[13px] font-medium leading-relaxed">${text}</p>
                        </div>
                        <p class="text-[9px] mt-1.5 font-bold text-slate-400 px-1 text-right">
                            ${time} • <span id="status-${id}">Mengirim...</span>
                        </p>
                    </div>
                </div>`;
            chatContainer.insertAdjacentHTML('beforeend', msgHtml);
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    </script>
</x-app-layout>