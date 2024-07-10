<?php
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Enums\NoteTypesEnum;

new #[Layout('layouts.app')] class extends Component {
    public function getBackRoute() : string
    {
        return url()->previous();
    }
}
?>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Create note') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-6 py-3 text-gray-900 dark:text-gray-100 flex justify-between items-center">
                <h2 class="font-bold text-lg">{{__('Create note')}}</h2>
                <x-button outline primary label="Back" :href="$this->getBackRoute()" wire:navigate/>
            </div>
            <hr class="mx-6">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <livewire:pages.notes.form/>
            </div>
        </div>
    </div>
</div>

