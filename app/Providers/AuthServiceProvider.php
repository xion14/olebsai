<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Log;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // $this->registerPolicies();
        // //
        // Gate::before(function ($user, $ability) {
        //     if ($user->hasRole('super admin')) {
        //         return true;
        //     }
        // });
        View::composer('*', function ($view) {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            Log::info('currentUserId ---> '.$user_id);
            $view->with('currentUserId', $user_id);
        } else {
            $view->with('currentUser', null);
        }
    });
    }
}
