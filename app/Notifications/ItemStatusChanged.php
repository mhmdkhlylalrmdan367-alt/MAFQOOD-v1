<?php

namespace App\Notifications;

use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ItemStatusChanged extends Notification
{
    use Queueable;

    public function __construct(public Item $item, public string $newStatus) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'item_status',
            'item_id' => $this->item->id,
            'title' => $this->item->title,
            'status' => $this->newStatus,
        ];
    }
}