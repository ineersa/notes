<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @property int $id
 * @property string $content
 * @property array|null $metadata
 * @property bool $shared
 * @property bool $public
 * @property bool $archived
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Note extends Model
{
    use \Spatie\Tags\HasTags;

    protected $connection = \App\Services\UserDatabasesService::CONNECTION_NAME;

    protected $fillable = [
        'content',
    ];

    protected $guarded = [
        'id',
        'created_at',
    ];

    public function casts()
    {
        return [
            'metadata' => 'array',
        ];
    }
}
