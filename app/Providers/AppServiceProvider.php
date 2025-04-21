<?php

namespace App\Providers;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\UserPolicy;
class AppServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Gate::define('manage-users', function ($user) {
            return $user->role === 'admin';
            
        });
        Gate::define('viewAny', function ($user) {
            return true; 
        });
        
        Gate::define('manage', function ($user) {
            return $user->is_admin; 
        });
    }
}
