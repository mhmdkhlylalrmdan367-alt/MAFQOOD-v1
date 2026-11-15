<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;

class ItemPolicy
{
    public function before(?User $user, string $ability): ?bool
    {
        if ($user && $user->isAdmin()) return true;
        return null;
    }

    public function update(User $user, Item $item): bool
    {
        return $user->id === $item->user_id;
    }

    public function delete(User $user, Item $item): bool
    {
        return $user->id === $item->user_id;
    }

    public function view(?User $user, Item $item): bool
    {
        if ($item->status === 'hidden') {
            return $user && ($user->id === $item->user_id || $user->isModerator());
        }
        return true;
    }
}