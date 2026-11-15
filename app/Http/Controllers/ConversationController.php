<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Item;
use App\Notifications\NewMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function index()
    {
        $conversations = Conversation::forUser(Auth::id())
            ->with(['item', 'sender', 'receiver'])
            ->orderByDesc('last_message_at')
            ->paginate(20);

        return view('conversations.index', compact('conversations'));
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

        return view('conversations.show', compact('conversation', 'messages'));
    }
}