<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Region;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $type = $request->input('type');
        $categoryId = $request->input('category');
        $regionId = $request->input('region');
        $status = $request->input('status');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $sort = $request->input('sort', 'latest');

        $items = Item::query()
            ->when($q, fn ($qb) => $qb->search($q))
            ->when($type, fn ($qb) => $qb->where('type', $type))
            ->when($categoryId, fn ($qb) => $qb->where('category_id', $categoryId))
            ->when($regionId, fn ($qb) => $qb->where('region_id', $regionId))
            ->when($status, fn ($qb) => $qb->where('status', $status), fn ($qb) => $qb->where('status', 'active'))
            ->when($dateFrom, fn ($qb) => $qb->whereDate('event_date', '>=', $dateFrom))
            ->when($dateTo, fn ($qb) => $qb->whereDate('event_date', '<=', $dateTo))
            ->with(['images', 'category', 'region'])
            ->orderBy('created_at', $sort === 'oldest' ? 'asc' : 'desc')
            ->paginate(12)->withQueryString();

        $categories = Category::active()->get();
        $regions = Region::where('is_active', true)->get();

        return view('search.index', compact('items', 'categories', 'regions', 'q'));
    }
}