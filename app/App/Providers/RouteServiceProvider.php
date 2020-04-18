<?php

namespace template\App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'template\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        Route::prefix('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web_administrator.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web_anonymous.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web_auth.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web_customer.php'));
    }
}
