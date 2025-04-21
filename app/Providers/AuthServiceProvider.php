<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Content;
use App\Policies\ContentPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Content::class => ContentPolicy::class,
        User::class => UserPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
