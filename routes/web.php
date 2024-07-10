<?php

use App\Enums\NoteTypesEnum;
use App\Http\Controllers\NotesTypeController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('/', 'pages.welcome');

Route::middleware([
    \Illuminate\Auth\Middleware\Authenticate::class,
    \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    \App\Http\Middleware\EnsureUserIsActive::class,
])
    ->group(function () {
        Volt::route('notes', 'pages.notes.notes')
            ->name('notes');
        Route::get('notes/{type}', NotesTypeController::class)
            ->whereIn('type', ['shared', 'public', 'archived'])
            ->name('notes-with-type');
        Volt::route('notes/create', 'pages.notes.create')
            ->name('notes-create');
        Volt::route('profile', 'pages.profile.profile')
            ->name('profile');
    });

require __DIR__.'/auth.php';
