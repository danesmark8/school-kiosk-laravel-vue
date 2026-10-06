@extends('layouts.kiosk')

@section('content')
<div class="container py-3" style="max-width: 960px;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="display-6 fw-bold text-dark mb-1">
                <i class="bi bi-credit-card-2-front-fill text-info me-2"></i> Payments Module
            </h1>
            <p class="text-muted fs-5 mb-0">Generate payment reference vouchers for Cashier settlement</p>
        </div>
        <a href="{{ route('kiosk.home') }}" class="btn btn-outline-primary btn-touch py-2 px-3">
            <i class="bi bi-house-door-fill"></i> Home
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
        <i class="bi bi-qr-code text-info fs-1 mb-2"></i>
        <h3 class="fw-bold">Payment Reference Generator</h3>
        <p class="text-muted">
            Authenticated as <strong>{{ $student->full_name }}</strong>. 
            Fee obligation selection, reference generation (`PAY-YYYYMM-XXXX`), and cashier printing will be unlocked in <strong>Phase 4: Payments Module</strong>.
        </p>
    </div>
</div>
@endsection
