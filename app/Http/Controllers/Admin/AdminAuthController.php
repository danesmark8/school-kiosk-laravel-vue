<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Handle admin login request.
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Attempt login using the admin guard
        if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $request->session()->regenerate();
            // Verify admin role (still using default user model)
            if (! Auth::guard('admin')->user()->hasRole('admin')) {
                Auth::guard('admin')->logout();

                return back()->withErrors(['email' => 'Unauthorized.']);
            }

            return redirect()->intended(route('admin.queue.index'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Log the admin out.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
