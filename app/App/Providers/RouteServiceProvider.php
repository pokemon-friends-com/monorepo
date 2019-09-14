<?php namespace obsession\App\Providers;

use Illuminate\{
    Foundation\Support\Providers\RouteServiceProvider as ServiceProvider,
    Support\Facades\Route
};

class RouteServiceProvider extends ServiceProvider
{

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'obsession\Http\Controllers';

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
        $this->mapAjaxRoutes();
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web_auth.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web_backend.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web_frontend.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web_customer.php'));
    }

    /**
     * Define the "ajax" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapAjaxRoutes()
    {
        Route::middleware('ajax')
            ->namespace($this->namespace)
            ->group(base_path('routes/ajax.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
