<?php

namespace App\Http\Controllers\Kiosk;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class KioskAnnouncementController extends Controller
{
    /**
     * Display public announcements on the kiosk.
     */
    public function index(Request $request): View
    {
        $type = $request->query('type');

        $query = Announcement::active()
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at');

        if ($type && in_array($type, ['general', 'academic', 'financial', 'emergency', 'kiosk'])) {
            $query->where('type', $type);
        }

        $announcements = $query->paginate(6)->withQueryString();

        return view('kiosk.announcements.index', compact('announcements', 'type'));
    }
}
