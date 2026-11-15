<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::active()
            ->withCount(['items' => fn ($q) => $q->where('status', 'active')])
            ->get();
        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        abort_unless($category->is_active, 404);
        $items = Item::active()
            ->where('category_id', $category->id)
            ->with(['images', 'region'])
            ->latest()->paginate(12);
        return view('categories.show', compact('category', 'items'));
    }
}