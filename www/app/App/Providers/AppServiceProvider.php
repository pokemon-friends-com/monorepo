<?php

namespace pkmnfriends\App\Providers;

use Illuminate\Support\{Facades\Config, Facades\Schema, Facades\URL, ServiceProvider};
use Barryvdh\{
    Debugbar\ServiceProvider as DebugbarServiceProvider,
    LaravelIdeHelper\IdeHelperServiceProvider
};
use Illuminate\Notifications\Messages\MailMessage;
use Sentry\Laravel\ServiceProvider as SentryServiceProvider;
use Yaquawa\Laravel\EmailReset\Notifications\EmailResetNotification;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     * @SuppressWarnings("unused")
     *
     * @return void
     */
    public function boot()
    {
        // @codeCoverageIgnoreStart
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        // https://laravel-news.com/laravel-5-4-key-too-long-error - mysql 5.6 @fortrabbit
        Schema::defaultStringLength(191);
        Config::set('sentry.release', Config::get('version.app_tag'));
        EmailResetNotification::toMailUsing(function ($user, $token, $resetLink) {
            return (new MailMessage())
                ->subject(trans('auth.email_reset_title'))
                ->view('emails.users.users.reset_email', compact('token'));
        });
        // @codeCoverageIgnoreEnd
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // @codeCoverageIgnoreStart
        if ($this->app->environment('local')) {
            $this->app->register(IdeHelperServiceProvider::class);
            $this->app->register(DebugbarServiceProvider::class);
        } elseif ($this->app->environment('production')) {
            $this->app->register(SentryServiceProvider::class);
        }
        // @codeCoverageIgnoreEnd
    }
}
