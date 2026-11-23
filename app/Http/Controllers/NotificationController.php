<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        return view('front.notifications.index', compact('notifications'));
    }

    public function markAsRead(string $id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return request()->expectsJson() ? response()->noContent() : back();
    }

    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', __('messages.notifications_marked_read'));
    }

    public function destroy(string $id)
    {
        Auth::user()->notifications()->findOrFail($id)->delete();
        return response()->noContent();
    }


    public function feed()
    {
        $notifications = Auth::user()->unreadNotifications()
            ->where('type', \App\Notifications\NewMessageNotification::class)
            ->latest()->limit(20)->get();

        return response()->json([
            'count' => Auth::user()->unreadNotifications()->count(),
            'entries' => Auth::user()->notifications()->latest()->limit(20)->get()->map(function ($notification) {
                $data = $notification->data;
                $url = null;
                $title = 'تحديث على بلاغك';
                if (($data['type'] ?? '') === 'new_message') {
                    $url = route('conversations.show', $data['conversation_id']);
                    $title = ($data['sender_name'] ?? 'مستخدم') . ' أرسل لك رسالة';
                } elseif (($data['type'] ?? '') === 'item_status' && isset($data['item_id'])) {
                    $url = route('items.show', $data['item_id']);
                }
                return ['id' => $notification->id, 'read' => (bool) $notification->read_at, 'read_url' => route('notifications.read', $notification->id), 'delete_url' => route('notifications.destroy', $notification->id), 'title' => $title, 'body' => $data['body'] ?? $data['status'] ?? '', 'url' => $url];
            }),

            'messages' => $notifications->map(fn ($notification) => [
                'id' => $notification->id,
                'sender' => $notification->data['sender_name'] ?? 'مستخدم',
                'body' => $notification->data['body'] ?? '',
                'url' => route('conversations.show', $notification->data['conversation_id']),
            ]),
        ])->header('Cache-Control', 'no-store');
    }
}
