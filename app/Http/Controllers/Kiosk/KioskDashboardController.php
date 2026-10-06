<?php

namespace App\Http\Controllers\Kiosk;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class KioskDashboardController extends Controller
{
    public function index(): View
    {
        $student = auth('student')->user();
        // Load the latest queue ticket for the student, if any
        $ticket = $student?->queueTickets()->orderByDesc('created_at')->first();

        return view('kiosk.dashboard', compact('student', 'ticket'));
    }
}
