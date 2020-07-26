<?php

namespace pkmnfriends\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use pkmnfriends\Infrastructure\Interfaces\Domain\Locale\LocalesInterface;

class Locale
{

    /**
     * Handle current locale.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (
            !Auth::check()
            && $request->get('locale')
            && in_array($request->get('locale'), LocalesInterface::LOCALES)
        ) {
            Session::put('locale', $request->get('locale'));
        } elseif (!Session::has('locale')) {
            Session::put('locale', LocalesInterface::DEFAULT_LOCALE);
        }

        app()->setLocale(Session::get('locale'));

        return $next($request);
    }
}
