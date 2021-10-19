<?php

if (! function_exists('settings')) {

    /**
     * Get app setting stored in db.
     *
     * @param $key
     * @param  null  $default
     * @return mixed
     */
    function settings($key = null, $default = null)
    {
        $setting = app()->make('QCod\Settings\Setting\SettingStorage');

        if (is_null($key)) {
            return $setting;
        }

        if (is_array($key)) {
            return $setting->set($key);
        }

        return $setting->get($key, value($default));
    }
}
