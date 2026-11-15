<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->query(), [
            'q' => ['nullable', 'string', 'max:120'],
            'type' => ['nullable', Rule::in(['lost', 'found'])],
            'category' => ['nullable', 'integer', 'min:1'],
            'region' => ['nullable', 'integer', 'min:1'],
            'status' => ['nullable', Rule::in(['active', 'resolved', 'closed', 'all'])],
            'date_from' => ['nullable', 'date_format:Y-m-d'],
            'date_to' => ['nullable', 'date_format:Y-m-d', Rule::when($request->filled('date_from'), 'after_or_equal:date_from')],
            'sort' => ['nullable', Rule::in(['latest', 'oldest', 'event_latest'])],
        ], [
            'date_to.after_or_equal' => 'تاريخ النهاية لازم يكون بعد تاريخ البداية أو بنفس اليوم.',
        ]);

        $invalid = $validator->fails();
        $filters = array_intersect_key($validator->valid(), $validator->getRules());
        $q = trim($filters['q'] ?? '');
        $status = $filters['status'] ?? 'active';
        $sort = $filters['sort'] ?? 'latest';

        $query = Item::query()
            ->whereIn('status', $status === 'all' ? ['active', 'resolved', 'closed'] : [$status])
            ->when($q !== '', fn ($query) => $query->search($q))
            ->when($filters['type'] ?? null, fn ($query, $type) => $query->where('type', $type))
            ->when($filters['category'] ?? null, fn ($query, $id) => $query->where('category_id', $id))
            ->when($filters['region'] ?? null, fn ($query, $id) => $query->where('region_id', $id))
            ->when($filters['date_from'] ?? null, fn ($query, $date) => $query->where('event_date', '>=', $date))
            ->when($filters['date_to'] ?? null, fn ($query, $date) => $query->where('event_date', '<=', $date))
            ->when($invalid, fn ($query) => $query->whereRaw('1 = 0'));

        if ($sort === 'event_latest') {
            $query->orderByRaw('CASE WHEN event_date IS NULL THEN 1 ELSE 0 END')->orderByDesc('event_date');
        }

        $direction = $sort === 'oldest' ? 'asc' : 'desc';
        $items = $query->with(['images', 'category', 'region'])
            ->orderBy('created_at', $direction)->orderBy('id', $direction)
            ->paginate(12)->appends($filters);

        $categories = Category::active()->orderBy('sort_order')->get();
        $regions = Region::where('is_active', true)->orderBy('name_ar')->get();

        return view('search.index', compact('items', 'categories', 'regions', 'filters', 'q'))
            ->with('filterErrors', $validator->errors());
    }
}

