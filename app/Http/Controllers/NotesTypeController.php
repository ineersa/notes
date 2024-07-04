<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Livewire\Volt\Volt;

class NotesTypeController extends Controller
{
    public function __invoke($type, \Livewire\Volt\LivewireManager $manager)
    {
        $component = $manager->new(
            'pages.notes.notes'
        );
        $component->type = $type;

        return $component->__invoke();

    }
}
