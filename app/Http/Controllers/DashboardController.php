<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate(['status' => ['nullable', Rule::in(['active', 'resolved', 'closed', 'hidden'])]]);
        $user = Auth::user();
        $stats = [
            'total' => $user->items()->count(),
            'active' => $user->items()->where('status', 'active')->count(),
            'resolved' => $user->items()->where('status', 'resolved')->count(),
            'unread_messages' => Message::whereHas('conversation', fn ($query) =>
                $query->where(fn ($query) => $query->where('sender_id', $user->id)->orWhere('receiver_id', $user->id))
            )->where('sender_id', '!=', $user->id)->whereNull('read_at')->count(),
        ];
        $items = $user->items()->with(['images', 'region'])
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->latest()->paginate(6)->appends($filters);
        $conversations = Conversation::query()
            ->where(fn ($query) => $query->where('sender_id', $user->id)->orWhere('receiver_id', $user->id))
            ->with(['sender', 'receiver', 'latestMessage'])->orderByDesc('last_message_at')->limit(3)->get();

        return view('front.dashboard.index', compact('stats', 'items', 'conversations'));
    }
}
