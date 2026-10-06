<!-- resources/views/components/kiosk/header.blade.php -->
@props(['title' => 'Kiosk'])
<header class="kiosk-header d-flex align-items-center justify-content-between px-3 py-2">
    <div class="d-flex align-items-center gap-2">
        <i class="bi bi-display-fill fs-3 text-white"></i>
        <h5 class="mb-0 fw-bold text-white">{{ $title }}</h5>
    </div>
    @auth('student')
        <div class="session-timer-pill d-flex align-items-center gap-2">
            <i class="bi bi-person-circle fs-5 text-warning"></i>
            <span>{{ Auth::guard('student')->user()->first_name }} ({{ Auth::guard('student')->user()->student_number }})</span>
            <span class="badge bg-warning text-dark ms-2" id="kiosk-timer-display">
                <i class="bi bi-clock-history"></i> <span id="timer-seconds">90</span>s
            </span>
        </div>
    @else
        <a href="{{ route('kiosk.login') }}" class="btn btn-warning btn-touch text-dark fw-bold">
            <i class="bi bi-shield-lock-fill"></i> Student Sign In
        </a>
    @endauth
</header>
