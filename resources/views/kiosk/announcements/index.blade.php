@extends('layouts.kiosk')

@section('content')
<div class="container py-4" style="max-width: 1080px;">
    <h2 class="display-6 fw-bold text-dark mb-4">Announcements</h2>

    @if($announcements->isEmpty())
        <p class="text-muted">No announcements at the moment.</p>
    @else
        @foreach($announcements as $announcement)
            <div class="card mb-3 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-2">{{ $announcement->title }}</h5>
                    <p class="card-text mb-1">{{ $announcement->content }}</p>
                    <small class="text-muted">
                        {{ $announcement->published_at->format('M d, Y') }}
                        @if($announcement->is_pinned)
                            <span class="badge bg-primary ms-2">Pinned</span>
                        @endif
                    </small>
                </div>
            </div>
        @endforeach

        <div class="d-flex justify-content-center mt-4">
            {{ $announcements->links() }}
        </div>
    @endif
</div>
@endsection
