<?php

namespace QCod\Settings;

use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Load migration
        $this->loadMigrationsFrom(__DIR__.'/migrations');

        // Publish migration
        $this->publishes([
            __DIR__.'/migrations/' => database_path('/migrations/'),
        ], 'migrations');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        // bind setting storage
        $this->app->bind(
            'QCod\Settings\Setting\SettingStorage',
            'QCod\Settings\Setting\SettingEloquentStorage'
        );
    }
}
