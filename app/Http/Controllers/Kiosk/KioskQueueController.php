<?php

namespace App\Http\Controllers\Kiosk;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\QueueTicket;
use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KioskQueueController extends Controller
{
    /**
     * Display office and service selection for queue ticketing.
     */
    public function index(): View
    {
        $offices = Office::where('is_active', true)
            ->with(['services' => fn ($q) => $q->where('is_active', true)])
            ->get();

        return view('kiosk.queue.index', compact('offices'));
    }

    /**
     * Handle ticket request for a service.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        $service = Service::findOrFail($data['service_id']);
        $student = auth('student')->user();

        // Determine daily sequence for this service
        $dailySequence = QueueTicket::whereDate('created_at', now()->toDateString())
            ->where('service_id', $service->id)
            ->count() + 1;

        $ticketNumber = $service->prefix.'-'.str_pad($dailySequence, 3, '0', STR_PAD_LEFT);

        QueueTicket::create([
            'ticket_number' => $ticketNumber,
            'daily_sequence' => $dailySequence,
            'service_id' => $service->id,
            'student_id' => $student->id,
            'status' => 'waiting',
            'issued_at' => now(),
        ]);

        return redirect(route('kiosk.dashboard'))
            ->with('success', 'Your ticket has been issued: '.$ticketNumber);
    }
}
