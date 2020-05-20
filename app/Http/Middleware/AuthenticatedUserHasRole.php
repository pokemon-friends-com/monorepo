<?php

namespace template\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Support\Facades\Gate;

class AuthenticatedUserHasRole
{

    /**
     * The authentication factory instance.
     *
     * @var Auth
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param Auth $auth
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
        $hasAccess = false;

        foreach ($roles as $role) {
            if (Gate::allows($role, $this->auth->user())) {
                $hasAccess = true;
                break;
            }
        }

        if (false === $hasAccess) {
            abort(403);
        }

        return $next($request);
    }
}
