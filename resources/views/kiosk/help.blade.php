@extends('layouts.kiosk')

@section('content')
<div class="container py-3" style="max-width: 960px;">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="display-6 fw-bold text-dark mb-1">
                <i class="bi bi-question-circle-fill text-primary me-2"></i> Kiosk Help & Assistance
            </h1>
            <p class="text-muted fs-5 mb-0">Frequently asked questions and instructions for using this self-service terminal</p>
        </div>
        <a href="{{ route('kiosk.home') }}" class="btn btn-outline-primary btn-touch py-2 px-3">
            <i class="bi bi-house-door-fill"></i> Home
        </a>
    </div>

    <div class="row g-4">
        <!-- FAQ 1: Security -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="bg-primary text-white rounded-3 p-2 px-3 fs-4">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4 class="fw-bold mb-0">Is My Information Safe?</h4>
                </div>
                <p class="text-muted mb-0 fs-6">
                    Yes. This kiosk is equipped with strict privacy protection. When you walk away or remain inactive for 90 seconds, the terminal immediately deletes all cached screens and forces an automatic logout. Another student cannot press "Back" to see your grades or balance.
                </p>
            </div>
        </div>

        <!-- FAQ 2: Forgotten PIN -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="bg-warning text-dark rounded-3 p-2 px-3 fs-4">
                        <i class="bi bi-key-fill"></i>
                    </div>
                    <h4 class="fw-bold mb-0">Forgot Your Security PIN?</h4>
                </div>
                <p class="text-muted mb-0 fs-6">
                    If you forgot your 4-digit PIN, please visit the <strong>Registrar's Office (Window 2)</strong> or the <strong>Campus IT Support Desk</strong> with your physical School ID to request a PIN reset.
                </p>
            </div>
        </div>

        <!-- FAQ 3: Queue Management -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="bg-success text-white rounded-3 p-2 px-3 fs-4">
                        <i class="bi bi-ticket-perforated"></i>
                    </div>
                    <h4 class="fw-bold mb-0">How Queueing Works</h4>
                </div>
                <p class="text-muted mb-0 fs-6">
                    Select <strong>Queue Management</strong> from the home screen, choose your destination office (Registrar, Cashier, Accounting), confirm your service, and receive your digital ticket number. Monitor the calling displays in the lobby.
                </p>
            </div>
        </div>

        <!-- FAQ 4: Official Payments -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="bg-info text-white rounded-3 p-2 px-3 fs-4">
                        <i class="bi bi-credit-card-2-front"></i>
                    </div>
                    <h4 class="fw-bold mb-0">Paying School Fees</h4>
                </div>
                <p class="text-muted mb-0 fs-6">
                    The Kiosk generates an authorized <strong>Payment Reference Voucher</strong>. Present this reference code at the Cashier window for rapid processing without filling out manual paper forms.
                </p>
            </div>
        </div>
    </div>

    <!-- Campus Office Directory -->
    <div class="card border-0 shadow-sm rounded-4 mt-4 p-4 bg-light">
        <h4 class="fw-bold mb-3"><i class="bi bi-building me-2 text-primary"></i> Campus Office Directory</h4>
        <div class="row row-cols-1 row-cols-md-3 g-3">
            <div class="col">
                <strong>Registrar's Office</strong><br>
                <small class="text-muted">Main Building, Windows 1-4 &bull; 8:00 AM - 5:00 PM</small>
            </div>
            <div class="col">
                <strong>Cashier's Office</strong><br>
                <small class="text-muted">Finance Wing, Windows 5-8 &bull; 8:00 AM - 4:30 PM</small>
            </div>
            <div class="col">
                <strong>Accounting Office</strong><br>
                <small class="text-muted">2nd Floor, Room 204 &bull; 8:30 AM - 5:00 PM</small>
            </div>
        </div>
    </div>

</div>
@endsection
