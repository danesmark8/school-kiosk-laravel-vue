@extends('layouts.kiosk')

@section('content')
<div class="container py-2" style="max-width: 1080px;">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="display-6 fw-bold text-dark mb-1">
                <i class="bi bi-ticket-perforated-fill text-primary me-2"></i> Queue Management
            </h1>
            <p class="text-muted fs-5 mb-0">Select an office to issue your transaction ticket</p>
        </div>
        <a href="{{ route('kiosk.home') }}" class="btn btn-outline-primary btn-touch py-2 px-3">
            <i class="bi bi-house-door-fill"></i> Home
        </a>
    </div>

    <div class="row g-4 row-cols-1 row-cols-md-2">
        @foreach($offices as $office)
            <div class="col">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-primary text-white fs-5 px-3 py-2 rounded-3">{{ $office->code }}</span>
                            <h3 class="fs-4 fw-bold text-dark mb-0">{{ $office->name }}</h3>
                        </div>
                    </div>

                    <p class="text-muted small mb-3">Available Services:</p>
                    <div class="d-grid gap-2">
                        @forelse($office->services as $service)
                        <form method="POST" action="{{ route('kiosk.queue.store') }}" class="w-100">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $service->id }}" />
                            <div class="p-3 border rounded-3 d-flex align-items-center justify-content-between bg-light">
                                <div>
                                    <span class="badge bg-secondary text-white me-2">Prefix: {{ $service->prefix }}</span>
                                    <strong class="text-dark">{{ $service->name }}</strong>
                                </div>
                                <span class="badge bg-info-subtle text-info-emphasis">~{{ $service->estimated_time_minutes }} mins</span>
                                <button type="submit" class="btn btn-primary btn-touch ms-2">Get Ticket</button>
                            </div>
                        </form>
                        @empty
                            <p class="text-muted small">No active services.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-center mt-5">
        <p class="text-muted">Full interactive queue dispensing will be unlocked in <strong>Phase 2: Queue Management Module</strong>.</p>
    </div>

</div>
@endsection
