<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $message = __('Already Authenticated');
            if ($request->expectsJson()) {
                return response()->json(['status' => 'error', 'message' => $message], 401);
            }

            return Auth::user()->user_type === 'admin' ? redirect('admin') : redirect('/');
        }

        return $next($request);
    }
}
