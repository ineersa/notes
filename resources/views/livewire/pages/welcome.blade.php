<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Enums\NoteTypesEnum;

new #[Layout('layouts.guest')] class extends Component {
    public function mount()
    {
        if (\auth()->check()) {
            $this->redirect(route('notes'), true);
        }
    }
}
?>

<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex h-32 justify-center">
    <div class="shrink-0 flex">
        <a href="/" wire:navigate>
            <x-application-logo class="block h-32 w-auto fill-current text-gray-800 dark:text-gray-200" />
        </a>
    </div>

    <div class="mx-8 text-gray-900 dark:text-gray-100 items-center justify-end flex">
        <x-button outline primary href="{{route('register')}}">Get Started</x-button>
    </div>
</div>
