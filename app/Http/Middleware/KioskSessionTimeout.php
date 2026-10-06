<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KioskSessionTimeout
{
    /**
     * Maximum allowed idle time in seconds on the kiosk terminal.
     */
    protected int $idleTimeoutSeconds = 90;

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('student')->check()) {
            $lastActivity = $request->session()->get('kiosk_last_activity');

            if ($lastActivity && (now()->timestamp - $lastActivity > $this->idleTimeoutSeconds)) {
                Auth::guard('student')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('kiosk.home')->with('warning', 'Your session has expired due to inactivity for your privacy and security.');
            }

            $request->session()->put('kiosk_last_activity', now()->timestamp);
        }

        return $next($request);
    }
}
