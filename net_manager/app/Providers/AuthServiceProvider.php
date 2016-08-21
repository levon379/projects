<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //Abilitity to edit users
        $gate->define('edit_user', function ($user) {
            return $user->hasRole('admin') ||$user->can('edit_user');
        });
        //Abilitity to create invoices
        $gate->define('create_invoice', function ($user) {
            return ($user->hasRole('admin') ||$user->can('create_invoice'));
        });
    }

}
