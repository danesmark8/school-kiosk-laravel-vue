<!-- resources/views/components/kiosk/button.blade.php -->
@props([
    'type' => 'button',
    'color' => 'primary', // primary, secondary, warning, danger, success
    'size' => 'md', // sm, md, lg
    'icon' => null,
    'href' => null,
])
@php
    $colorClasses = [
        'primary' => 'bg-primary text-white border-primary hover:bg-[#1e2e8a] focus:ring-2 focus:ring-primary',
        'secondary' => 'bg-secondary text-white border-secondary hover:bg-[#0275c7] focus:ring-2 focus:ring-secondary',
        'warning' => 'bg-warning text-black border-warning hover:bg-[#ffca2c] focus:ring-2 focus:ring-warning',
        'danger' => 'bg-danger text-white border-danger hover:bg-[#dc2626] focus:ring-2 focus:ring-danger',
        'success' => 'bg-success text-white border-success hover:bg-[#16a34a] focus:ring-2 focus:ring-success',
    ];
    $sizeClasses = [
        'sm' => 'text-sm py-1 px-3',
        'md' => 'text-base py-2 px-4',
        'lg' => 'text-lg py-3 px-5',
    ];
@endphp
@if($href)
    <a href="{{ $href }}" class="kiosk-nav-card btn-touch {{ $colorClasses[$color] ?? $colorClasses['primary'] }} {{ $sizeClasses[$size] ?? $sizeClasses['md'] }}">
        @if($icon)
            <i class="{{ $icon }} me-2"></i>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" class="kiosk-nav-card btn-touch {{ $colorClasses[$color] ?? $colorClasses['primary'] }} {{ $sizeClasses[$size] ?? $sizeClasses['md'] }}">
        @if($icon)
            <i class="{{ $icon }} me-2"></i>
        @endif
        {{ $slot }}
    </button>
@endif
