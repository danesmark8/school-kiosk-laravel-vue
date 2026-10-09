@extends('layouts.admin')

@section('content')
<div class="container py-4" style="max-width: 1080px;">
    <h1 class="display-6 fw-bold mb-4">Queue Management Dashboard</h1>
    @if($tickets->isEmpty())
        <p class="text-muted">No tickets found.</p>
    @else
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ticket Number</th>
                    <th>Service</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ticket->ticket_number }}</td>
                        <td>{{ $ticket->service->name ?? 'N/A' }}</td>
                        <td>{{ ucfirst($ticket->status) }}</td>
                        <td>{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($ticket->status === 'waiting')
                                <form method="POST" action="{{ route('admin.queue.callNext') }}" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="service_id" value="{{ $ticket->service_id }}" />
                                    <button type="submit" class="btn btn-sm btn-primary">Call Next</button>
                                </form>
                            @endif
                            @if($ticket->status === 'called')
                                <form method="POST" action="{{ route('admin.queue.serve', $ticket) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Serve</button>
                                </form>
                            @endif
                            @if($ticket->status === 'serving')
                                <form method="POST" action="{{ route('admin.queue.complete', $ticket) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Complete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
