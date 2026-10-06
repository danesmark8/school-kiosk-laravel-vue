<?php

namespace App\Http\Controllers\Kiosk;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class KioskSoaController extends Controller
{
    /**
     * Display student statement of account summary.
     */
    public function index(): View
    {
        $student = Auth::guard('student')->user();

        return view('kiosk.soa.index', compact('student'));
    }
}
