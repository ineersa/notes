<?php

namespace App\Services;

class UserDatabasesService
{
    public const CONNECTION_NAME = 'user_db';

    public function __construct(
        private readonly \Illuminate\Encryption\Encrypter $encrypter,
        private readonly string $path,
    ) {}

    /**
     * @param  int|null|string  $userId
     */
    public function setupDatabase($userId): void
    {
        if ($userId !== null) {
            $db = \App\Models\UserDatabase::whereUserId($userId)->first();

            if (! $db) {
                $db = new \App\Models\UserDatabase();
                $db->db_name = uniqid("id_{$userId}_").'.sqlite';
                $db->db_password = $this->encrypter->encryptString(\Str::password(16));
                $db->options = [];
                $db->user_id = $userId;
                $db->save();
            }

            if (! \File::exists($this->getFilename($db->db_name))) {
                $sqlite = new \SQLite3(
                    filename: $this->getFilename($db->db_name),
                    flags: SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE,
                    encryptionKey: $this->encrypter->decryptString($db->db_password)
                );
                $sqlite->close();
            }
            \Config::set('database.connections.'.self::CONNECTION_NAME, [
                'driver' => 'sqlite',
                'database' => $this->getFilename($db->db_name),
                'encryption_key' => $this->encrypter->decryptString($db->db_password),
                'prefix' => '',
                'foreign_key_constraints' => true,
            ]);
        }
    }

    private function getFilename(string $db_name): string
    {
        return $this->path.DIRECTORY_SEPARATOR.$db_name;
    }
}
