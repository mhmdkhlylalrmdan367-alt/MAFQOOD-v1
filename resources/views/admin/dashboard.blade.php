@extends('layouts.admin')

@section('title', 'لوحة المعلومات')

@section('content')

{{-- Stats --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-xs text-gray-500 mb-1">المستخدمون</div>
                <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['users']) }}</div>
            </div>
            <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-xs text-gray-500 mb-1">الإعلانات</div>
                <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['items']) }}</div>
            </div>
            <div class="w-10 h-10 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-box"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-xs text-gray-500 mb-1">مفقودات</div>
                <div class="text-2xl font-bold text-red-500">{{ number_format($stats['lost']) }}</div>
            </div>
            <div class="w-10 h-10 bg-red-100 text-red-600 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-circle-exclamation"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-xs text-gray-500 mb-1">موجودات</div>
                <div class="text-2xl font-bold text-green-500">{{ number_format($stats['found']) }}</div>
            </div>
            <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-hand-holding-heart"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5">
        <div class="text-xs text-gray-500 mb-1">تم استرجاعها</div>
        <div class="text-2xl font-bold text-emerald-500">{{ number_format($stats['resolved']) }}</div>
    </div>
    <a href="{{ route('admin.reports.index') }}" class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition">
        <div class="text-xs text-gray-500 mb-1">إجمالي البلاغات</div>
        <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['reports']) }}</div>
    </a>
    <a href="{{ route('admin.reports.index', ['status' => 'pending']) }}" class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition">
        <div class="text-xs text-gray-500 mb-1">بلاغات قيد المراجعة</div>
        <div class="text-2xl font-bold text-yellow-600">{{ number_format($stats['pending_reports']) }}</div>
    </a>
</div>

{{-- Charts --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="font-bold text-gray-900 mb-4">الإعلانات آخر 6 أشهر</h2>
        <canvas id="monthlyChart" height="200"></canvas>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="font-bold text-gray-900 mb-4">توزيع الإعلانات على التصنيفات</h2>
        <canvas id="categoryChart" height="200"></canvas>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const monthlyLabels = @json($monthlyItems->pluck('month'));
    const monthlyData = @json($monthlyItems->pluck('total'));

    new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'الإعلانات',
                data: monthlyData,
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37,99,235,0.1)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    const catLabels = @json($categoryStats->pluck('name_ar'));
    const catData = @json($categoryStats->pluck('items_count'));

    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: catLabels,
            datasets: [{
                data: catData,
                backgroundColor: [
                    '#2563eb', '#f59e0b', '#10b981', '#ef4444', '#8b5cf6',
                    '#ec4899', '#14b8a6', '#f97316', '#6366f1', '#84cc16'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endpush