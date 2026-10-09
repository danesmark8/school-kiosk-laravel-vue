<?php

namespace App\Http\Controllers\Kiosk;

use App\Http\Controllers\Controller;
use App\Models\QueueTicket;
use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KioskQueueAdminController extends Controller
{
    /**
     * Display the queue management dashboard for staff.
     */
    public function index(): View
    {
        // Show all tickets grouped by status for the staff view
        $tickets = QueueTicket::with('service')
            ->orderByDesc('created_at')
            ->get();

        return view('kiosk.queue.manage', compact('tickets'));
    }

    /**
     * Call the next waiting ticket for a given service.
     */
    public function callNext(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        $service = Service::findOrFail($data['service_id']);

        // Get the earliest waiting ticket for this service
        $ticket = QueueTicket::where('service_id', $service->id)
            ->where('status', 'waiting')
            ->orderBy('created_at')
            ->first();

        if (! $ticket) {
            return redirect()->back()->with('warning', 'No waiting tickets for this service.');
        }

        $ticket->update([
            'status' => 'called',
            'called_at' => now(),
            'called_by_user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', "Ticket {$ticket->ticket_number} called.");
    }

    /**
     * Mark a ticket as served.
     */
    public function serve(Request $request, QueueTicket $ticket): RedirectResponse
    {
        $ticket->update([
            'status' => 'serving',
            'served_at' => now(),
        ]);

        return redirect()->back()->with('success', "Ticket {$ticket->ticket_number} is now being served.");
    }

    /**
     * Complete a ticket.
     */
    public function complete(Request $request, QueueTicket $ticket): RedirectResponse
    {
        $ticket->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return redirect()->back()->with('success', "Ticket {$ticket->ticket_number} completed.");
    }
}
