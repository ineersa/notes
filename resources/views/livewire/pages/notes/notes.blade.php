<?php
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Enums\NoteTypesEnum;

new #[Layout('layouts.app')] class extends Component {

    public $type = null;

}
?>


<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __(NoteTypesEnum::getNoteTypeTitle(\App\Enums\NoteTypesEnum::tryFrom($type))) }}
    </h2>
</x-slot>

<div class="py-12">
    <div>
        <div class="grid grid-cols-10 gap-4 mx-4">
            <div class="col-span-2">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg min-h-screen-1/2">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h2 class="font-bold text-lg">{{__('Filters')}}</h2>
                        <hr class="mt-2 mb-4">
                        <div>
                            Filters content
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg min-h-screen-1/2">
                    <div class="px-6 py-3 text-gray-900 dark:text-gray-100 flex justify-between items-center">
                        <h2 class="font-bold text-lg">{{__('Notes list')}}</h2>
                        <x-button outline primary label="Create"/>
                    </div>
                    <hr class="mx-6">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        notes?
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

