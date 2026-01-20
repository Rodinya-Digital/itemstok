<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

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
            return redirect('/home');
        }
        $session = $request->getSession();
        if (!$session->has('locale')) {
            $session->put('locale', $request->getPreferredLanguage(array_keys(Config::get('app.locales'))));
        }
        if ($request->has('setLang')) {
            $setLang= $request->get('setLang');
            if (in_array($setLang, array_keys(Config::get('app.locales')))) {
                $session->put('locale', $setLang);
            }
        }
        App::setlocale($session->get('locale'));

        return $next($request);
    }
}
