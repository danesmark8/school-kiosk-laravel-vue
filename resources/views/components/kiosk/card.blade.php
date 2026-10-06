<!-- resources/views/components/kiosk/card.blade.php -->
@props([
    'title',
    'icon',
    'url',
    'description' => null,
    'color' => 'primary',
])
<a href="{{ $url }}" class="kiosk-nav-card text-decoration-none">
    @if($icon)
        <div class="icon-wrapper bg-{{ $color }} text-white mb-3">
            <i class="{{ $icon }} fs-1"></i>
        </div>
    @endif
    <h5 class="fw-semibold mb-2">{{ $title }}</h5>
    @if($description)
        <p class="text-muted mb-0">{{ $description }}</p>
    @endif
</a>
