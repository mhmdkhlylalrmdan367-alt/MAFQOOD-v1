<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\ItemRequest;
use App\Models\Category;
use App\Models\Item;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::active()->with(['category', 'region', 'images', 'user']);

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }
        if ($categoryId = $request->input('category')) {
            $query->where('category_id', $categoryId);
        }
        if ($regionId = $request->input('region')) {
            $query->where('region_id', $regionId);
        }

        $items = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::active()->get();
        $regions = Region::where('is_active', true)->get();

        return view('items.index', compact('items', 'categories', 'regions'));
    }

    public function show(Item $item)
    {
        $this->authorize('view', $item);
        $item->increment('views_count');
        $item->load(['category', 'region', 'images', 'user']);

        $related = Item::active()
            ->where('category_id', $item->category_id)
            ->where('id', '!=', $item->id)
            ->latest()->take(4)->get();

        return view('items.show', compact('item', 'related'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        $regions = Region::where('is_active', true)->get();
        return view('items.create', compact('categories', 'regions'));
    }

    public function store(ItemRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['status'] = 'active';

        $item = Item::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('items', 'public');
                $item->images()->create([
                    'path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('items.show', $item)
            ->with('success', __('messages.item_created'));
    }

    public function edit(Item $item)
    {
        $this->authorize('update', $item);
        $categories = Category::active()->get();
        $regions = Region::where('is_active', true)->get();
        $item->load('images');
        return view('items.edit', compact('item', 'categories', 'regions'));
    }

    public function update(ItemRequest $request, Item $item)
    {
        $this->authorize('update', $item);
        $item->update($request->validated());

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('items', 'public');
                $item->images()->create([
                    'path' => $path,
                    'sort_order' => $item->images()->count() + $index,
                ]);
            }
        }

        return redirect()->route('items.show', $item)
            ->with('success', __('messages.item_updated'));
    }

    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);
        foreach ($item->images as $img) {
            Storage::disk('public')->delete($img->path);
        }
        $item->delete();

        return redirect()->route('items.index')->with('success', __('messages.item_deleted'));
    }

    public function updateStatus(Request $request, Item $item)
    {
        $this->authorize('update', $item);
        $request->validate([
            'status' => 'required|in:active,resolved,closed,hidden',
        ]);
        $item->update(['status' => $request->input('status')]);

        return back()->with('success', __('messages.item_status_updated'));
    }

    public function destroyImage(Item $item, $imageId)
    {
        $this->authorize('update', $item);
        $image = $item->images()->findOrFail($imageId);
        Storage::disk('public')->delete($image->path);
        $image->delete();
        return back()->with('success', __('messages.image_deleted'));
    }
}