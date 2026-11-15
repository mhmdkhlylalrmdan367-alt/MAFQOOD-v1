<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = ['item_id', 'sender_id', 'receiver_id', 'last_message_at'];

    protected $casts = ['last_message_at' => 'datetime'];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at');
    }

    public function otherUser(int $userId): User
    {
        return $this->sender_id === $userId ? $this->receiver : $this->sender;
    }

    public function scopeForUser($q, int $userId)
    {
        return $q->where('sender_id', $userId)->orWhere('receiver_id', $userId);
    }
}