@props(['type' => 'info', 'message'])

@php
    $colors = [
        'info' => 'bg-primary-100 text-brand border-brand',
        'success' => 'bg-green-100 text-green-700 border-green-400',
        'warning' => 'bg-yellow-100 text-yellow-700 border-yellow-400',
        'error' => 'bg-red-100 text-red-700 border-red-400',
    ];
    $icons = [
        'info' => 'fa-circle-info',
        'success' => 'fa-check-circle',
        'warning' => 'fa-triangle-exclamation',
        'error' => 'fa-circle-exclamation',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'border px-4 py-3 rounded-lg ' . $colors[$type]]) }}>
    <i class="fa-solid {{ $icons[$type] }} ml-2"></i>
    {{ $message }}
</div>