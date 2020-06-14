<?php

namespace Joesama\Profile;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class ProfileProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(ProfileEventProvider::class);

        $this->app['router']->middleware('signed', \Illuminate\Routing\Middleware\ValidateSignature::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $dir = dirname(__DIR__);

        $this->loadMigrationsFrom($dir . '/database/migrations');

        $this->loadRoutesFrom($dir . '/routes/web.php');

        $this->loadViewsFrom($dir . '/resources/views', 'profile');

        $this->loadTranslationsFrom($dir . '/resources/lang', 'profile');

        $this->publishes([
            $dir . '/resources/configs/profile.php' => config_path('profile.php'),
        ], 'config');

        $this->publishes([
            $dir . '/resources/lang' => resource_path('lang/vendor/profile'),
        ]);
    }
}
