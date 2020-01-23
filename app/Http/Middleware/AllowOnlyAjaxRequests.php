<?php namespace template\Http\Middleware;

use Closure;

class AllowOnlyAjaxRequests
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->ajax()) {
            return response(trans('errors.405_title'), 405);
        }

        return $next($request);
    }
}
