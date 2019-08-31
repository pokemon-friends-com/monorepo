<?php namespace obsession\Http\Middleware;

use Closure;
use obsession\Infrastructure\Interfaces\Domain\Locale\TimeZonesInterface;

class TimeZones
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
        if (!\Session::has('timezone')) {
            \Session::put('timezone', TimeZonesInterface::DEFAULT_TZ);
        }

        app('config')->set('app.timezone', \Session::get('timezone'));

        return $next($request);
    }
}
