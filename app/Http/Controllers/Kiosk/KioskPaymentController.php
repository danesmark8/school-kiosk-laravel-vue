<?php

namespace App\Http\Controllers\Kiosk;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class KioskPaymentController extends Controller
{
    /**
     * Display payment reference generator.
     */
    public function index(): View
    {
        $student = Auth::guard('student')->user();

        return view('kiosk.payments.index', compact('student'));
    }
}
