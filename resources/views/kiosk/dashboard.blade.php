@extends('layouts.kiosk')

@section('content')
<div class="container py-4" style="max-width: 1080px;">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-4">
        <h2 class="display-6 fw-bold text-dark">Welcome, {{ $student->name ?? 'Student' }}</h2>
    </div>

    @if (isset($ticket) && $ticket)
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <h5 class="mb-3">Your Ticket</h5>
            <p class="mb-1"><strong>Ticket Number:</strong> {{ $ticket->ticket_number }}</p>
            <p class="mb-1"><strong>Service:</strong> {{ $ticket->service->name }}</p>
            <p class="mb-1"><strong>Issued At:</strong> {{ $ticket->issued_at->format('Y-m-d H:i') }}</p>
        </div>
    @else
        <p class="text-muted">You have no active tickets.</p>
    @endif

    <a href="{{ route('kiosk.queue.index') }}" class="btn btn-primary btn-touch">
        <i class="bi bi-ticket-perforated-fill me-2"></i> Get New Ticket
    </a>
</div>
@endsection
