<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Item;
use App\Notifications\NewMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'unread' => ['nullable', 'in:1'],
        ]);
        $q = trim($filters['q'] ?? '');
        $userId = Auth::id();
        $conversations = Conversation::query()
            ->where(fn ($query) => $query->where('sender_id', $userId)->orWhere('receiver_id', $userId))
            ->when($q !== '', fn ($query) => $query->where(function ($query) use ($q, $userId) {
                $query->whereHas('item', fn ($item) => $item->where('title', 'like', '%'.$q.'%'))
                    ->orWhereHas('sender', fn ($user) => $user->where('id', '!=', $userId)->where('name', 'like', '%'.$q.'%'))
                    ->orWhereHas('receiver', fn ($user) => $user->where('id', '!=', $userId)->where('name', 'like', '%'.$q.'%'));
            }))
            ->when($filters['unread'] ?? false, fn ($query) => $query->whereHas('messages', fn ($messages) => $messages->where('sender_id', '!=', $userId)->whereNull('read_at')))
            ->with(['item.images', 'sender', 'receiver', 'latestMessage'])
            ->withCount(['messages as unread_count' => fn ($messages) => $messages->where('sender_id', '!=', $userId)->whereNull('read_at')])
            ->orderByDesc('last_message_at')->orderByDesc('id')->paginate(20)->appends($filters);

        return view('front.conversations.index', compact('conversations', 'q'));
    }


    public function store(Request $request)
{
    \Log::info('=== Conversation Store START ===', [
        'auth_id' => Auth::id(),
        'auth_name' => Auth::user()?->name,
        'item_id' => $request->input('item_id'),
        'item_owner_id' => \App\Models\Item::find($request->input('item_id'))?->user_id,
    ]);

    $data = $request->validate([
        'item_id' => 'required|exists:items,id',
        'body' => 'required|string|min:2|max:2000',
    ]);

    $item = Item::findOrFail($data['item_id']);
    abort_if($item->user_id === Auth::id(), 403, 'لا يمكنك مراسلة نفسك');

    \Log::info('=== Conversation Store: PASSED abort_if ===');

    $conversation = Conversation::firstOrCreate([
        'item_id' => $item->id,
        'sender_id' => Auth::id(),
        'receiver_id' => $item->user_id,
    ]);

    \Log::info('=== Conversation created/found ===', ['conversation_id' => $conversation->id]);

    $message = $conversation->messages()->create([
        'sender_id' => Auth::id(),
        'body' => $data['body'],
    ]);

    $conversation->update(['last_message_at' => now()]);

    $item->user->notify(new NewMessageNotification($message));

    return redirect()->route('conversations.show', $conversation);
}
    public function show(Conversation $conversation)
    {
        \Log::info('=== Conversation Show START ===', [
        'auth_id' => Auth::id(),
        'conversation_id' => $conversation->id,
        'sender_id' => $conversation->sender_id,
        'receiver_id' => $conversation->receiver_id,
    ]);

    $this->authorize('view', $conversation);

    \Log::info('=== Conversation Show: PASSED authorize ===');



        $conversation->messages()
            ->where('sender_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = $conversation->messages()->with('sender')->get();
        $conversation->load(['item', 'sender', 'receiver']);
        $other = $conversation->otherUser(Auth::id());
        Auth::user()->unreadNotifications()
            ->where('type', NewMessageNotification::class)->get()
            ->filter(fn ($notification) => (int) ($notification->data['conversation_id'] ?? 0) === (int) $conversation->id)
            ->each->markAsRead();

        if (request()->expectsJson()) {
            return response()->json([
                'html' => view('front.conversations.messages', compact('messages', 'other'))->render(),
            ])->header('Cache-Control', 'no-store');
        }

        return view('front.conversations.show', compact('conversation', 'messages'));
    }
}
