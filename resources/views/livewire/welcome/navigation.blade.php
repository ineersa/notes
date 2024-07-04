<nav class="-mx-3 flex flex-1 justify-end">
    <!-- Navigation Menu -->
    @guest
        <div class="flex space-x-8 -my-px ms-10">
            <x-nav-link :href="route('login')" :active="request()->routeIs('login')" wire:navigate>
                {{ __('Login') }}
            </x-nav-link>
        </div>

        @if (Route::has('register'))
            <div class="flex space-x-8 -my-px ms-10">
                <x-nav-link :href="route('register')" :active="request()->routeIs('register')" wire:navigate>
                    {{ __('Register') }}
                </x-nav-link>
            </div>
        @endif
    @endguest
    <livewire:components.theme-switcher/>

</nav>
