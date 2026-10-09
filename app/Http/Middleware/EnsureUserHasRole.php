<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (! $user || ! $user->hasRole('admin')) {
            // You could also redirect or show a custom view, but aborting with 403 is simple.
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
