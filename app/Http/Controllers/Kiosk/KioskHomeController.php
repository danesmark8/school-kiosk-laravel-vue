<?php

namespace App\Http\Controllers\Kiosk;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class KioskHomeController extends Controller
{
    /**
     * Display the Kiosk touch-friendly main home screen.
     */
    public function index(): View
    {
        $student = Auth::guard('student')->user();

        $announcements = Announcement::active()
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->take(5)
            ->get();

        return view('kiosk.home', compact('student', 'announcements'));
    }
}
