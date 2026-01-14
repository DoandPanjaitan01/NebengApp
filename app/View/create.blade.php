<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buka Tebengan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form method="POST" action="{{ route('trips.store') }}">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="origin" :value="__('Lokasi Asal (Contoh: Gerbang Kampus)')" />
                        <x-text-input id="origin" class="block mt-1 w-full" type="text" name="origin" required autofocus />
                        <x-input-error :messages="$errors->get('origin')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="destination" :value="__('Lokasi Tujuan')" />
                        <x-text-input id="destination" class="block mt-1 w-full" type="text" name="destination" required />
                        <x-input-error :messages="$errors->get('destination')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-input-label for="departure_time" :value="__('Waktu Berangkat')" />
                            <x-text-input id="departure_time" class="block mt-1 w-full" type="datetime-local" name="departure_time" required />
                        </div>
                        <div>
                            <x-input-label for="empty_seats" :value="__('Jumlah Kursi')" />
                            <x-text-input id="empty_seats" class="block mt-1 w-full" type="number" name="empty_seats" required />
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="price" :value="__('Biaya Per Orang (Rp)')" />
                        <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" required />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Catatan Tambahan (Opsional)')" />
                        <textarea name="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Publikasikan Tebengan') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>