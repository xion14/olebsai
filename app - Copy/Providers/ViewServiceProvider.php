<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SettingContactAdmin;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }
    
    public function boot()
    {
        View::composer('*', function ($view) {
            try {
                $contactAdmin = SettingContactAdmin::first();
            } catch (\Exception $e) {
                $contactAdmin = ['contact' => ''];
            }
            $view->with('contactAdmin', $contactAdmin);
        });
    }
}
