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

        $this->publishes([
            $dir.'/resources/configs/profile.php' => config_path('profile.php'),
        ], 'config');
    }
}
