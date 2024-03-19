<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->header('APP-LOCALE');
        $validLocales = ['ru', 'en'];

        if (in_array($locale, $validLocales)) {
            app()->setLocale($locale);
        } else {
            app()->setLocale(config('app.locale'));
        }
        return $next($request);
    }
}
