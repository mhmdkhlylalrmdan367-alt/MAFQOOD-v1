<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $latestLost = Item::active()->lost()->with(['category', 'region', 'images'])
            ->latest()->take(6)->get();

        $latestFound = Item::active()->found()->with(['category', 'region', 'images'])
            ->latest()->take(6)->get();

        $categories = Category::active()
            ->withCount(['items' => fn ($q) => $q->where('status', 'active')])
            ->get();

        $stats = [
            'users' => User::count(),
            'items' => Item::where('status', 'active')->count(),
            'lost' => Item::where('status', 'active')->where('type', 'lost')->count(),
            'found' => Item::where('status', 'active')->where('type', 'found')->count(),
            'resolved' => Item::where('status', 'resolved')->count(),
        ];

        return view('front.home.index', compact('latestLost', 'latestFound', 'categories', 'stats'));
    }
}
