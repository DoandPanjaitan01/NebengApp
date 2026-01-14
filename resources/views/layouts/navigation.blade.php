<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>

    <x-nav-link :href="route('trips.my-trips')" :active="request()->routeIs('trips.my-trips')">
        {{ __('Tebengan Saya (Driver)') }}
    </x-nav-link>
    
    <x-nav-link :href="route('trips.create')" :active="request()->routeIs('trips.create')">
        {{ __('Buka Tebengan') }}
    </x-nav-link>
</div>