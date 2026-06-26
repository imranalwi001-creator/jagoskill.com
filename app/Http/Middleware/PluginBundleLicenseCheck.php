<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PluginBundleLicenseCheck
{
    /**
     * Handle an incoming request.
     * Bypassing all license checks to ensure no features are locked.
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
