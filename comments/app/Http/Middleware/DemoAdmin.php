<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class DemoAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->check() || Auth::user()->username === 'demo') {
            if ($request->expectsJson()) {
                return response()->json(['status' => 'error', 'message' => __('You have no permission to do that with DEMO ACCOUNT')]);
            }

            return response(__('You have no permission to do that'));
        }

        return $next($request);
    }
}
