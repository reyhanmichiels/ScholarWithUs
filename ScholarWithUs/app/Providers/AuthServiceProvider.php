<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Program;
use App\Models\User;
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
     */
    public function boot(): void
    {
        Gate::define('only-Admin', function(User $user) {
            return $user->role == 'admin';
        });

        Gate::define('user-program', function(User $user, Program $program){
            if ($user->programs->find($program->id) == null) {
                return false;
            }

            return true;
        });
    }
}
