<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
   public function index()
{
    $user = Auth::user();

    // إحصائيات المستخدم الشخصية
    $stats = [
        'total' => $user->items()->count(),
        'lost' => $user->items()->where('type', 'lost')->count(),
        'found' => $user->items()->where('type', 'found')->count(),
        'active' => $user->items()->where('status', 'active')->count(),
        'resolved' => $user->items()->where('status', 'resolved')->count(),
        'unread_messages' => Message::whereHas('conversation', function ($q) use ($user) {
            $q->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
        })->where('sender_id', '!=', $user->id)->whereNull('read_at')->count(),
    ];

    // إحصائيات المنصة (لكل المستخدمين)
    $platformStats = [
        'total_users' => \App\Models\User::count(),
        'total_items' => \App\Models\Item::where('status', 'active')->count(),
        'total_lost' => \App\Models\Item::where('status', 'active')->where('type', 'lost')->count(),
        'total_found' => \App\Models\Item::where('status', 'active')->where('type', 'found')->count(),
        'total_resolved' => \App\Models\Item::where('status', 'resolved')->count(),
    ];

    $items = $user->items()->with('images')->latest()->take(10)->get();

    return view('dashboard.index', compact('stats', 'platformStats', 'items'));
}
}