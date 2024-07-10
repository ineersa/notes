<?php

use App\Models\Note;
use App\Services\NotesService;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Volt\Component;
use Filament\Forms\Form;

new /**
 * @property Form|null $form
 */
class extends Component implements HasForms {

    use InteractsWithForms;

    public ?array $data = [];
    public Note $note;
    private NotesService $notesService;

    public function boot(NotesService $notesService)
    {
        $this->notesService = $notesService;
    }

    public function mount(Note $note): void
    {
        $this->note = $note;
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                MarkdownEditor::make('content')
                    ->required()
                    ->minLength(5),
                SpatieTagsInput::make('tags')
                    ->type('notes')
                    ->required(),
            ])
            ->statePath('data')
            ->model($this->note);
    }

    public function submit(): void
    {
        $this->form->validate();
        if ($this->note->exists) {
            $this->notesService->updateNote($this->note, $this->data);
        } else {
            $this->notesService->createNote($this->data);
        }
    }
}
?>

<form wire:submit="submit">
    {{ $this->form }}

    <hr class="my-4">
    <div class="text-gray-900 dark:text-gray-100 flex justify-end items-center">
        <x-button outline primary label="Submit" type="submit"/>
    </div>

</form>


