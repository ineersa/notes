<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    protected $fillable = [
        'content',
        'archived',
    ];

    protected $guarded = [
        'id',
        'created_at',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
