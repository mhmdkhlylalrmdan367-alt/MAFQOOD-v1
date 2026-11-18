<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\Conversation;
use App\Notifications\NewMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $request, Conversation $conversation)
    {
         Log::info('Message store called', [
        'user_id' => Auth::id(),
        'conversation_id' => $conversation->id,
        'sender_id' => $conversation->sender_id,
        'receiver_id' => $conversation->receiver_id,
    ]);
       $this->authorize('view', $conversation);

        $data = $request->validate(['body' => 'required|string|min:1|max:2000']);

        $message = $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'body' => $data['body'],
        ]);

        $conversation->update(['last_message_at' => now()]);

        $recipient = $conversation->otherUser(Auth::id());
        $recipient->notify(new NewMessageNotification($message));

        return back();
    }
}