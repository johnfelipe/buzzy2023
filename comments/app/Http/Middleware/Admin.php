<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
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
        if (!Auth::guard($guard)->check() || Auth::user()->user_type !== 'admin') {
            if ($request->expectsJson()) {
                return response()->json(['status' => 'error', 'message' => __('You have no permission to do that')], 401);
            }

            return response(__('You have no permission to do that') . ' <a href="'.url('/api/login').'">' . __('Login to Admin Account').'</a>', 401);
        }

        return $next($request);
    }
}
