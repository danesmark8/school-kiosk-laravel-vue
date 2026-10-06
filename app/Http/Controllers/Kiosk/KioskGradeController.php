<?php

namespace App\Http\Controllers\Kiosk;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class KioskGradeController extends Controller
{
    /**
     * Display student grades summary.
     */
    public function index(): View
    {
        $student = Auth::guard('student')->user();

        return view('kiosk.grades.index', compact('student'));
    }
}
