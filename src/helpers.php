<?php

if (! function_exists('settings')) {

    /**
     * Get app setting stored in db.
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    function settings($key = null, $default = null)
    {
        if (is_null($key)) {
            return app()->make('QCod\Settings\Setting\SettingStorage');
        }

        if (is_array($key)) {
            return app()->make('QCod\Settings\Setting\SettingStorage')->set($key);
        }

        return app()->make('QCod\Settings\Setting\SettingStorage')->get($key, value($default));
    }
}
