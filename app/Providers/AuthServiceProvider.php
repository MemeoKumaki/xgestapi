<?php

namespace xgestapi\Providers;

use Carbon\Carbon;
use xgestapi\Cliente;
use xgestapi\Policies\ClientePolicy;
use \Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
       Cliente::class => ClientePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        Gate::define('admin-action', function($user){
            return $user->esAdministrador();
        });
        
        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addMinute(480));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        

        //
    }
}
