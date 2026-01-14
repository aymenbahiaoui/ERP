<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define("admin",function(User $user){
            return $user->role == 'admin';
        });

        Gate::define("dg",function(User $user){
            return $user->role == 'dg';
        });
        Gate::define("dc",function(User $user){
            return $user->role == 'dc';
        });
        Gate::define("df",function(User $user){
            return $user->role == 'df';
        });

        Gate::define("dg",function(User $user){
            return $user->role == 'dg';
        });
        Gate::define("comp",function(User $user){
            return $user->role == 'comp';
        });
        Gate::define("comm",function(User $user){
            return $user->role == 'comm';
        });
        Gate::define("sup",function(User $user){
            return $user->role == 'sup';
        });
    }
}
