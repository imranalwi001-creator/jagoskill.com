<?php

namespace App\Http\Middleware;

use Closure;

class WebAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            return $next($request);
        }

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('public.not_login_toast_lang'),
                'msg' => trans('public.not_login_toast_msg_lang'),
                'status' => 'error'
            ], 401);
        }

        return redirect('/login');
    }
}
