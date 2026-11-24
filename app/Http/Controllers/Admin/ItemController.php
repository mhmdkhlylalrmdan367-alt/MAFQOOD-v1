<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
class ItemController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('items.view');
        $query = Item::with(['user', 'category', 'images'])->latest();

        if ($search = $request->input('q')) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($categoryId = $request->input('category')) {
            $query->where('category_id', $categoryId);
        }

        $items = $query->paginate(20)->withQueryString();
        $categories = Category::all();

        return view('admin.items.index', compact('items', 'categories'));
    }

    public function show(Item $item)
    {
        Gate::authorize('items.view');
        $item->load(['user', 'category', 'region', 'images', 'reports']);
        return view('admin.items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        Gate::authorize('items.update');
        $categories = Category::all();
        return view('admin.items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        Gate::authorize('items.update');
        $data = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'status' => ['required', 'in:active,resolved,closed,hidden'],
        ]);

        $item->update($data);
        return redirect()->route('admin.items.index')->with('success', 'تم تحديث الإعلان');
    }

    public function destroy(Item $item)
    {
        Gate::authorize('items.delete');
        $item->delete();
        return redirect()->route('admin.items.index')->with('success', 'تم حذف الإعلان');
    }

    public function updateStatus(Request $request, Item $item)
    {
        $request->validate([
            'status' => 'required|in:active,resolved,closed,hidden',
        ]);

        $item->update(['status' => $request->input('status')]);
        return back()->with('success', 'تم تغيير حالة الإعلان');
    }
}
