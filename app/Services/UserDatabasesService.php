<?php

namespace App\Services;

class UserDatabasesService
{
    public const CONNECTION_NAME = 'user_db';

    public function __construct(
        private readonly \Illuminate\Encryption\Encrypter $encrypter,
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

            \Config::set('database.connections.'.self::CONNECTION_NAME, [
                'driver' => 'libsql',
                'url' => 'libsql::file:'.$this->getFilename($db->db_name),
                'encryptionKey' => $this->encrypter->decryptString($db->db_password),
                'authToken' => '',
                'syncUrl' => '',
                'syncInterval' => 5,
                'read_your_writes' => true,
                'remoteOnly' => false,
                'database' => null,
                'prefix' => '',
            ]);
        }
    }

    private function getFilename(string $db_name): string
    {
        return 'users_databases'.DIRECTORY_SEPARATOR.$db_name;
    }
}
