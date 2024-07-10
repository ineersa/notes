<?php
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Enums\NoteTypesEnum;

new #[Layout('layouts.app')] class extends Component {

    public $type = null;

    public bool $filtersOpen = false;

    public function toggleFilters(): void
    {
        $this->filtersOpen = !$this->filtersOpen;
    }

}
?>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __(NoteTypesEnum::getNoteTypeTitle(\App\Enums\NoteTypesEnum::tryFrom($type))) }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center">
                    <h2 class="font-bold text-lg">{{__('Filters')}}</h2>
                    <button wire:click="toggleFilters" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        @if($filtersOpen)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        @endif
                    </button>
                </div>
                <div x-data="{ open: @entangle('filtersOpen') }" x-show="open" x-transition>
                    <hr class="mb-4">
                    <div class="grid grid-cols-3 gap-4">
                        <!-- Add your filter content here -->
                        <div>
                            <label class="block text-sm font-medium mb-1" for="search">Search</label>
                            <input type="text" id="search" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-6 py-3 text-gray-900 dark:text-gray-100 flex justify-between items-center">
                <h2 class="font-bold text-lg">{{__('Notes list')}}</h2>
                <x-button outline primary label="Create" :href="route('notes-create')" wire:navigate/>
            </div>
            <hr class="mx-6">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                NOTES CONTENT
            </div>
        </div>
    </div>
</div>

