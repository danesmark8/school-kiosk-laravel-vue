<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::guard('student')->check()) {
            return redirect()->guest(route('kiosk.login'))
                ->with('info', 'Please sign in with your Student ID and PIN to access this private service.');
        }

        return $next($request);
    }
}
