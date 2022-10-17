<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define("admin",function($user){
            return $user->hasRole("admin"); 
        });
        Gate::define("enseignant",function($user){
            return $user->hasRole("enseignant"); 
        });
        Gate::define("etudiant",function($user){
            return $user->hasRole("etudiant"); 
        });
        Gate::define("respModule",function($user){
            return $user->hasRole("respModule"); 
        });
        Gate::define("respFiliere",function($user){
            return $user->hasRole("respFiliere"); 
        });
    }
}
