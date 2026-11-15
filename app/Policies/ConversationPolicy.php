<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;

class ConversationPolicy
{
    public function view(User $user, Conversation $conversation): bool
    {
        return in_array($user->id, [$conversation->sender_id, $conversation->receiver_id]);
    }

    public function create(User $user): bool
    {
        return true;
    }
}