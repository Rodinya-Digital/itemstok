<?php

namespace App\Http\Middleware;

use Closure;

class PhoneVerify
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->phone_verify == null && request()->route()->getName() != 'panel.phone_verify' && !auth()->user()->hasRole('Admin')) {
            return redirect()->route('panel.phone_verify');
        }
        if (auth()->user()->phone_verify != null && request()->route()->getName() == 'panel.phone_verify') {
            return redirect()->route('panel.user.dashboard');
        }
        return $next($request);
    }
}
