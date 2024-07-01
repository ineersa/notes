<?php

use Livewire\Volt\Component;

new class extends Component {

    public string $theme = 'system';

    protected $listeners = ['theme-switcher.change-theme' => 'setTheme'];

    public function mount(): void
    {
        $this->theme = session('theme', 'system');
        $this->dispatch('theme-changed', theme: $this->theme);
    }

    public function updatedTheme($value): void
    {
        session(['theme' => $value]);
        $this->dispatch('theme-switcher.theme-changed', theme: $value);
    }

    public function setTheme($theme): void
    {
        $this->theme = $theme;
        $this->updatedTheme($theme);
    }

    public function getSystemTheme(): string
    {
        return 'system';
    }
}; ?>

<div x-data="{
    theme: @entangle('theme'),
    dropdownOpen: false,
    changeTheme() {
        if (this.theme === 'dark' || (this.theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.style.colorScheme = 'dark';
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.style.colorScheme = 'light';
            document.documentElement.classList.remove('dark');
        }
    },
    getSystemThemeName() {
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }
}"
     x-init="
     $nextTick(() => {
        if (theme === 'system') {
            $wire.setTheme(getSystemThemeName());
        } else {
            changeTheme();
        }
        });
    $watch('theme', value => {
        changeTheme();
    });
    $wire.on('theme-changed', ({ theme }) => {
        $nextTick(() => changeTheme());
    });
"
     class="relative inline-flex items-center ml-6 px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out"
>
    <div>
        <button @click="dropdownOpen = !dropdownOpen" type="button" aria-haspopup="menu" :aria-expanded="dropdownOpen" class="flex items-center justify-center w-8 h-8 rounded-full focus:outline-none" aria-label="Theme switcher">
            <template x-if="theme === 'dark'">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6 text-gray-900 dark:text-gray-100">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
            </template>
            <template x-if="theme === 'light'">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6 text-gray-900 dark:text-gray-100">
                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                </svg>
            </template>
        </button>
    </div>
    <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-0 top-8 z-50 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 dark:bg-gray-800" aria-labelledby="mode-select-button" role="menu" tabindex="-1">
        <div class="p-1" role="none">
            <button @click="$wire.setTheme('light'); dropdownOpen = false" class="group flex w-full items-center rounded-md px-2 py-2 text-sm" role="menuitem" tabindex="-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6 text-gray-900 dark:text-gray-100 mr-2">
                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                </svg>
                Light
            </button>
            <button @click="$wire.setTheme('dark'); dropdownOpen = false" class="group flex w-full items-center rounded-md px-2 py-2 text-sm" role="menuitem" tabindex="-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6 text-gray-900 dark:text-gray-100 mr-2">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                Dark
            </button>
            <button @click="$wire.setTheme(getSystemThemeName()); dropdownOpen = false" class="group flex w-full items-center rounded-md px-2 py-2 text-sm" role="menuitem" tabindex="-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-gray-900 dark:text-gray-100 mr-2">
                    <rect x="3" y="3" width="14" height="10" rx="2" ry="2"></rect>
                    <line x1="7" y1="17" x2="13" y2="17"></line>
                    <line x1="10" y1="13" x2="10" y2="17"></line>
                </svg>
                System
            </button>
        </div>
    </div>
</div>
