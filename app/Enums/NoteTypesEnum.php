<?php

namespace App\Enums;

enum NoteTypesEnum: string
{
    use EnumToArrayTrait;
    case SHARED = 'shared';
    case PUBLIC = 'public';
    case ARCHIVED = 'archived';

    public static function getNoteTypeTitle(?NoteTypesEnum $value = null): string
    {
        return match ($value) {
            NoteTypesEnum::SHARED => 'Shared notes',
            NoteTypesEnum::PUBLIC => 'Public notes',
            NoteTypesEnum::ARCHIVED => 'Archived notes',
            default => 'Notes',
        };
    }
}
