@php
    $buttonClass = "px-4 pt-2 pb-3 flex items-center text-sm text-gray-700 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out";
@endphp

    <!-- Responsive Theme Switcher -->
<div class="py-2 w-full text-start">
    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Theme</span>
    <div class="mt-2 flex flex-col space-y-1">
        <button wire:click="$dispatch('theme-switcher.change-theme', {theme:'light'})" class="{{ $buttonClass }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 mr-2">
                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
            </svg>
            Light
        </button>
        <button wire:click="$dispatch('theme-switcher.change-theme', {theme:'dark'})" class="{{ $buttonClass }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 mr-2">
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
            </svg>
            Dark
        </button>
        <button wire:click="$dispatch('theme-switcher.change-theme', {theme:'system'})" class="{{ $buttonClass }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 mr-2">
                <rect x="3" y="3" width="14" height="10" rx="2" ry="2"></rect>
                <line x1="7" y1="17" x2="13" y2="17"></line>
                <line x1="10" y1="13" x2="10" y2="17"></line>
            </svg>
            System
        </button>
    </div>
</div>
