<?php

namespace App\Services;

use App\Models\Note;
use Illuminate\Support\Facades\DB;

class NotesService
{
    /**
     * @throws \Throwable
     */
    public function createNote(array $data): Note
    {
        \DB::connection(UserDatabasesService::CONNECTION_NAME)
            ->beginTransaction();
        try {
            $model = new Note($data);
            $model->public = false;
            $model->shared = false;
            $model->archived = false;
            $model->metadata = [];

            $model->save();
            $model->refresh();
            $model->syncTagsWithType($data['tags'] ?? [], 'notes');
            \DB::connection(UserDatabasesService::CONNECTION_NAME)
                ->commit();
        } catch (\Throwable $e) {
            \DB::connection(UserDatabasesService::CONNECTION_NAME)
                ->rollBack();
            throw $e;
        }

        return $model;
    }

    /**
     * @throws \Throwable
     */
    public function updateNote(Note $note, array $data): Note
    {
        \DB::connection(UserDatabasesService::CONNECTION_NAME)
            ->beginTransaction();
        try {
            $note->update($data);
            \DB::connection(UserDatabasesService::CONNECTION_NAME)
                ->commit();
        } catch (\Throwable $e) {
            \DB::connection(UserDatabasesService::CONNECTION_NAME)
                ->rollBack();
            throw $e;
        }

        return $note;
    }
}
