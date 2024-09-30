<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
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
        if ($locale = $request->session()->get('locale')) {
            App::setLocale($locale);
        }
        if (Session::has('applocale')) {
            App::setLocale(Session::get('applocale'));
        }

        return $next($request);
    }
}
