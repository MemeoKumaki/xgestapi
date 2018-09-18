<?php

namespace xgestapi\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        \Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
             echo '<pre>';
             print_r([ $query->sql, $query->time, $query->bindings]);
             echo '</pre>';
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
