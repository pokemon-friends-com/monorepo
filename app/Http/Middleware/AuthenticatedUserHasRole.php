<?php namespace template\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Support\Facades\Gate;

class AuthenticatedUserHasRole
{

    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory $auth
     *
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param         $request
     * @param Closure $next
     * @param array ...$roles
     *
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {

        $has_access = false;

        foreach ($roles as $role) {
            if (Gate::allows($role, $this->auth->user())) {
                $has_access = true;
                break;
            }
        }

        if (false === $has_access) {
            abort(403);
        }

        return $next($request);
    }
}
