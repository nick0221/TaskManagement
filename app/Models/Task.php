<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'status',
        'published_at',
        'published',
        'subtask',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
