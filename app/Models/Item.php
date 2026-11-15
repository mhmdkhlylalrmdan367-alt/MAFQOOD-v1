<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'category_id', 'region_id', 'type', 'title',
        'description', 'location_description', 'event_date', 'status',
    ];

    protected $casts = [
        'event_date' => 'date',
        'views_count' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ItemImage::class)->orderBy('sort_order');
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('status', 'active');
    }

    public function scopeLost(Builder $q): Builder
    {
        return $q->where('type', 'lost');
    }

    public function scopeFound(Builder $q): Builder
    {
        return $q->where('type', 'found');
    }

    public function scopeSearch(Builder $q, ?string $term): Builder
    {
        if (!$term) return $q;
        return $q->where(function ($w) use ($term) {
            $w->where('title', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%")
              ->orWhere('location_description', 'like', "%{$term}%");
        });
    }

    public function getFirstImageUrlAttribute(): string
    {
        $img = $this->images->first();
        return $img ? asset('storage/' . $img->path) : asset('images/placeholder.png');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'active' => __('messages.status.active'),
            'resolved' => __('messages.status.resolved'),
            'closed' => __('messages.status.closed'),
            'hidden' => __('messages.status.hidden'),
            default => $this->status,
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return $this->type === 'lost'
            ? __('messages.type.lost')
            : __('messages.type.found');
    }
}