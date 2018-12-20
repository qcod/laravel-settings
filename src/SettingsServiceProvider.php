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

        // publish migration
        $this->publishes([
            __DIR__.'/migrations/2014_10_00_000000_create_settings_table.php' => database_path('/migrations/2014_10_00_000000_create_settings_table'),
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
