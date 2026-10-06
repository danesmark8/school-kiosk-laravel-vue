<?php

namespace App\Http\Controllers\Kiosk;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class KioskAuthController extends Controller
{
    /**
     * Show the kiosk student login view.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::guard('student')->check()) {
            return redirect()->route('kiosk.home');
        }

        return view('kiosk.auth.login');
    }

    /**
     * Handle student authentication via Student ID and PIN.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'student_number' => ['required', 'string', 'max:30'],
            'pin' => ['required', 'numeric', 'digits_between:4,6'],
        ]);

        $student = Student::where('student_number', $credentials['student_number'])
            ->where('status', 'active')
            ->first();

        if (! $student || ! Hash::check($credentials['pin'], $student->pin_hash)) {
            return back()->withErrors([
                'student_number' => 'Invalid Student Number or PIN. Please try again.',
            ])->withInput($request->only('student_number'));
        }

        Auth::guard('student')->login($student);
        $request->session()->regenerate();
        $request->session()->put('kiosk_last_activity', now()->timestamp);

        return redirect()->intended(route('kiosk.home'))
            ->with('success', "Welcome, {$student->first_name}!");
    }

    /**
     * Log the student out and purge kiosk session data.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('kiosk.home')
            ->with('info', 'You have been safely logged out. Thank you for using the Kiosk.');
    }
}
