<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

//Schema::create('notes', function (Blueprint $table) {
//    $table->id();
//    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
//    $table->text('content')->comment("Content of the note in markdown format");
//    $table->boolean('archived')->default(false)->comment("Is note archived");
//    $table->timestamps();
//});

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
