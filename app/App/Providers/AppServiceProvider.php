<?php namespace obsession\App\Providers;

use Illuminate\Support\{
    Facades\URL,
    ServiceProvider
};
use Barryvdh\{
    Debugbar\ServiceProvider as DebugbarServiceProvider,
    LaravelIdeHelper\IdeHelperServiceProvider
};
use Sentry\Laravel\ServiceProvider as SentryServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(IdeHelperServiceProvider::class);
            $this->app->register(DebugbarServiceProvider::class);
        } elseif ($this->app->environment('production')) {
            $this->app->register(SentryServiceProvider::class);
        }
    }
}
