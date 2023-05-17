<?php

namespace App\Installer\Middleware;

use Closure;
use App\Installer\InstallerConfig;

class Installer
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
        if (!$this->is_installed() && !$request->is('installer')) {
            return redirect(url('installer'));
        }

        if ($this->is_installed() && $this->is_update_needed() && !$request->is('installer/update')) {
            return redirect(url('installer/update'));
        }

        if ($this->is_installed() && !$this->is_update_needed() && ($request->is('installer') || $request->is('installer/update'))) {
            return redirect(url('/'));
		}

        return $next($request);
    }

	public function is_installed()
	{
		return file_exists(storage_path('installed'));
	}

	public function is_update_needed()
	{
        $config = new InstallerConfig;
		$version = @file_get_contents(storage_path('installed'));
		return $version && version_compare($version, $config::$version, '<');
	}
}
