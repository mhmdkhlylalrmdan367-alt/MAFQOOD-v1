<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'items' => Item::count(),
            'lost' => Item::where('type', 'lost')->count(),
            'found' => Item::where('type', 'found')->count(),
            'resolved' => Item::where('status', 'resolved')->count(),
            'reports' => Report::count(),
            'pending_reports' => Report::where('status', 'pending')->count(),
        ];

        // إحصائيات الإعلانات آخر 6 أشهر
        $monthlyItems = Item::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw('count(*) as total')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // توزيع الإعلانات على التصنيفات
        $categoryStats = Category::withCount('items')
            ->orderByDesc('items_count')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'monthlyItems', 'categoryStats'));
    }
}