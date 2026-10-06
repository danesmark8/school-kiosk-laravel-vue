<!-- resources/views/kiosk/welcome.blade.php -->
@extends('layouts.kiosk')

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center min-vh-100 text-center">
    <h1 class="mb-4 fw-bold">Welcome to<br>School Self‑Service Kiosk</h1>
    <a href="{{ route('kiosk.home') }}" class="btn btn-primary btn-touch btn-lg">
        <i class="bi bi-hand-index-thumb"></i> Tap to Start
    </a>
    <div class="mt-5 w-75">
        <!-- Simple rotating announcements (placeholder) -->
        <div id="welcome-announcements" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <p class="text-muted">Enrollment opens soon – check the Admissions desk.</p>
                </div>
                <div class="carousel-item">
                    <p class="text-muted">Payment deadline: 15th of each month.</p>
                </div>
                <div class="carousel-item">
                    <p class="text-muted">Campus event: Open house this Friday.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
