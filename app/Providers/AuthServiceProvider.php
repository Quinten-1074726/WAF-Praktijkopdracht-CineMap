<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // Model => Policy mapping (mag leeg blijven)
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('admin-access', function ($user) {
            return $user->role === 'admin';
        });
        Gate::define('use-watchlist', function ($user) {
            return ! $user->can('admin-access');
    });
    }
}
