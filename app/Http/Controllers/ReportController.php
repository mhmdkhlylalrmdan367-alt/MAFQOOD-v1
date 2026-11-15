<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function create(Item $item)
    {
        return view('reports.create', compact('item'));
    }

    public function store(Request $request, Item $item)
    {
        $data = $request->validate([
            'reason' => 'required|in:spam,fraud,wrong_category,offensive,duplicate,other',
            'details' => 'nullable|string|max:1000',
        ]);

        $exists = Report::where('user_id', Auth::id())
            ->where('reportable_type', Item::class)
            ->where('reportable_id', $item->id)
            ->exists();

        if ($exists) {
            return back()->with('error', __('messages.report_already_sent'));
        }

        Report::create([
            'user_id' => Auth::id(),
            'reportable_type' => Item::class,
            'reportable_id' => $item->id,
            'reason' => $data['reason'],
            'details' => $data['details'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('items.show', $item)
            ->with('success', __('messages.report_submitted'));
    }
}