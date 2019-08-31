<?php namespace obsession\App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use obsession\Infrastructure\Interfaces\Domain\Users\Users\UserRolesInterface;

class AuthServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define(UserRolesInterface::ROLE_ACCOUNTANT, function ($user) {
            return $user->is_accountant;
        });

        Gate::define(UserRolesInterface::ROLE_ADMINISTRATOR, function ($user) {
            return $user->is_administrator;
        });

        Gate::define(UserRolesInterface::ROLE_CUSTOMER, function ($user) {
            return $user->is_customer;
        });
    }
}
