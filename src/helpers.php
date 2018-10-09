<?php

if (! function_exists('setting')) {

    /**
     * Get app setting stored in db.
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    function setting($key = null, $default = null)
    {
        if (is_null($key)) {
            return app()->make('SettingStorage');
        }

        if (is_array($key)) {
            return app()->make('SettingStorage')->set($key);
        }

        return app()->make('SettingStorage')->get($key, value($default));
    }
}
