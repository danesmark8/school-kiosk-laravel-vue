@extends('layouts.kiosk')

@section('content')
<div class="container-fluid px-4">

    <!-- Top Announcement Bulletin Banner -->
    @if($announcements->isNotEmpty())
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(90deg, #eff6ff 0%, #ffffff 100%); border-left: 6px solid #2563eb !important;">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <span class="badge bg-primary text-white p-2 px-3 rounded-pill fs-6">
                    <i class="bi bi-megaphone-fill me-1"></i> Bulletin
                </span>
                <div class="flex-grow-1 overflow-hidden">
                    <marquee behavior="scroll" direction="left" scrollamount="6" class="fs-5 fw-semibold text-primary mb-0">
                        @foreach($announcements as $announcement)
                            &bull; <strong class="text-dark">[{{ strtoupper($announcement->type) }}]</strong> {{ $announcement->title }}: {{ Str::limit($announcement->content, 90) }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        @endforeach
                    </marquee>
                </div>
            </div>
        </div>
    @endif

    <!-- Welcome & Greeting Card -->
    <div class="text-center mb-4">
        @auth('student')
            <div class="badge bg-success-subtle text-success fs-6 px-3 py-2 rounded-pill mb-2">
                <i class="bi bi-patch-check-fill me-1"></i> Verified Student Session
            </div>
            <h1 class="display-6 fw-bold text-dark">Welcome, {{ $student->first_name }}!</h1>
            <p class="text-muted fs-5">Please select the transaction or inquiry service you wish to perform.</p>

        @else
            <h1 class="display-5 fw-bold text-dark">Welcome to the Campus Kiosk</h1>
            <p class="text-muted fs-5">Tap a service below to get started. Academic & financial inquiries require your Student ID & PIN.</p>
        @endauth
    </div>

    <!-- 6 Primary Kiosk Modules Grid -->
    <div class="row g-4 row-cols-1 row-cols-md-2 row-cols-lg-3 mb-4">

        <!-- 1. Queue Management -->
        <div class="col">
    <x-kiosk-card
        title="Queue Management"
        icon="bi bi-ticket-perforated-fill"
        url="{{ route('kiosk.queue.index') }}"
        description="Get a queue ticket for Registrar, Cashier, Accounting & Admissions"
    />
</div>

        <!-- 2. Statement of Account -->
        <div class="col">
    <x-kiosk-card
        title="Statement of Account"
        icon="bi bi-wallet2"
        url="{{ route('kiosk.soa.index') }}"
        description="Check your current balance, fee assessment, discounts & payment records"
    />
</div>

        <!-- 3. Payments -->
        <div class="col">
    <x-kiosk-card
        title="Payments"
        icon="bi bi-credit-card-2-front-fill"
        url="{{ route('kiosk.payments.index') }}"
        description="Generate unique payment reference codes & cashier settlement vouchers"
        color="info"
    />
</div>

        <!-- 4. Grades Inquiry -->
        <div class="col">
    <x-kiosk-card
        title="Grades"
        icon="bi bi-mortarboard-fill"
        url="{{ route('kiosk.grades.index') }}"
        description="View officially released subject final marks, semester units & GPA"
        color="warning"
    />
</div>

<div class="col">
    <x-kiosk-card
        title="Dashboard"
        icon="bi bi-speedometer2"
        url="{{ route('kiosk.dashboard') }}"
        description="Quick overview of your session and queue status"
        color="secondary"
    />
</div>

        <!-- 5. Campus Announcements -->
        <div class="col">
            <a href="{{ route('kiosk.announcements.index') }}" class="kiosk-nav-card">
                <div class="icon-wrapper bg-secondary text-white shadow">
                    <i class="bi bi-newspaper"></i>
                </div>
                <h3 class="fs-4 fw-bold mb-2">Announcements</h3>
                <p class="text-muted mb-0 small">Read university notices, exam dates, academic deadlines & campus news</p>
                <div class="mt-3">
                    <span class="btn btn-outline-secondary btn-touch py-1 px-4 fs-6">
                        Browse News <i class="bi bi-arrow-right"></i>
                    </span>
                </div>
            </a>
        </div>

        <!-- 6. Help & Assistance -->
        <div class="col">
            <a href="{{ route('kiosk.help') }}" class="kiosk-nav-card">
                <div class="icon-wrapper bg-dark text-white shadow">
                    <i class="bi bi-question-circle-fill"></i>
                </div>
                <h3 class="fs-4 fw-bold mb-2">Help & Assistance</h3>
                <p class="text-muted mb-0 small">How to use this terminal, security advice & office directory</p>
                <div class="mt-3">
                    <span class="btn btn-outline-dark btn-touch py-1 px-4 fs-6">
                        Get Help <i class="bi bi-arrow-right"></i>
                    </span>
                </div>
            </a>
        </div>

    </div>

</div>
@endsection
