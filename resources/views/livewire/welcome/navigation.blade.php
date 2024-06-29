<nav class="-mx-3 flex flex-1 justify-end">
    @auth
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-nav-link>
        </div>
    @else
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link :href="route('login')" :active="request()->routeIs('login')" wire:navigate>
                {{ __('Login') }}
            </x-nav-link>
        </div>

        @if (Route::has('register'))
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <x-nav-link :href="route('register')" :active="request()->routeIs('register')" wire:navigate>
                    {{ __('Register') }}
                </x-nav-link>
            </div>
        @endif
    @endauth
    <livewire:components.theme-switcher />
</nav>
