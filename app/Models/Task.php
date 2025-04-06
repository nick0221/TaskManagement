<?php

namespace App\Models;

use App\Enums\PublishStatus;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        'user_id'
    ];

    public static function filterTasks(int $user, Request $request): Builder
    {

        $query = self::query()->where('user_id', $user);

        // Apply status filter if provided
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Apply search query filter if provided
        $searchQuery = $request->query('search');
        if (is_string($searchQuery)) {
            $query->where('title', 'like', '%'.$searchQuery.'%');
        }

        return $query;
    }


    public function getLimitedTitleAttribute(): string
    {
        return Str::limit((string) $this->title, 20, '...');
    }


    public function getLimitedContentAttribute(): string
    {
        return Str::limit($this->content, 20, '...');
    }


    public function getFormattedDateAttribute(): string
    {
        return Carbon::parse($this->created_at)->format('M d, Y');
    }


    public function getImagePathAttribute(): string
    {
        return $this->image ? asset('storage/task-images/'.$this->image) : asset('images/default.png');
    }

    public function setPublishedAttribute($value): void
    {
        $this->attributes['published'] = $value;

        // Update 'published_at' if 'published' is set to 1
        if ($value == 1) {
            $this->attributes['published_at'] = Carbon::now('Asia/Manila');
        } else {
            $this->attributes['published_at'] = null; // Reset 'published_at' if 'published' is not 1
        }
    }


    public function getPublishedStrAttribute(): string
    {
        $publishedValue = (int) $this->published;
        return PublishStatus::fromValue($publishedValue)->label($publishedValue);
    }


    public function getDiffTimeAttribute(): string
    {
        if ($this->created_at) {
            return Carbon::parse($this->created_at)->diffForHumans();
        }

        return ''; // or any default value you prefer when 'created_at' is null
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
