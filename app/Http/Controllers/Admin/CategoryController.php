<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
class CategoryController extends Controller
{
    public function index()
    {
        Gate::authorize('categories.view');
        $categories = Category::withCount('items')->orderBy('sort_order')->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        Gate::authorize('categories.create');
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('categories.create');
        $data = $request->validate([
            'name_ar' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['slug'] = Str::slug($data['name_en']) . '-' . Str::random(4);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'تم إنشاء التصنيف');
    }

    public function edit(Category $category)
    {
        Gate::authorize('categories.update');
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        Gate::authorize('categories.update');
        $data = $request->validate([
            'name_ar' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'تم تحديث التصنيف');
    }

    public function destroy(Category $category)
    {
        Gate::authorize('categories.delete');
        if ($category->items()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف تصنيف يحتوي على إعلانات');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'تم حذف التصنيف');
    }
}
