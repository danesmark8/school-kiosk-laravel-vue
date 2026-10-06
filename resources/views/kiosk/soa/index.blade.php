@extends('layouts.kiosk')

@section('content')
<div class="container py-3" style="max-width: 960px;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="display-6 fw-bold text-dark mb-1">
                <i class="bi bi-wallet2 text-success me-2"></i> Statement of Account
            </h1>
            <p class="text-muted fs-5 mb-0">Financial records for <strong>{{ $student->full_name }}</strong> ({{ $student->student_number }})</p>
        </div>
        <a href="{{ route('kiosk.home') }}" class="btn btn-outline-primary btn-touch py-2 px-3">
            <i class="bi bi-house-door-fill"></i> Home
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
        <i class="bi bi-shield-lock-fill text-success fs-1 mb-2"></i>
        <h3 class="fw-bold">Authenticated Kiosk Zone</h3>
        <p class="text-muted">
            You are securely authenticated as <strong>{{ $student->full_name }}</strong>. 
            Full itemized term breakdown, fee adjustments, and receipts will be unlocked in <strong>Phase 3: Information Services</strong>.
        </p>
    </div>
</div>
@endsection
