<?php

namespace QCod\Settings\Setting;

use Illuminate\Support\Facades\Cache;

class SettingEloquentStorage implements SettingStorage
{
    /**
     * Cache key.
     *
     * @var string
     */
    protected $settingsCacheKey = 'app_settings';

    /**
     * {@inheritdoc}
     */
    public function all($fresh = false)
    {
        if ($fresh) {
            return $this->getSettingModel()->pluck('val', 'name');
        }

        return Cache::rememberForever($this->settingsCacheKey, function () {
            return $this->getSettingModel()->pluck('val', 'name');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null, $fresh = false)
    {
        $configValue = $this->all($fresh)->get($key, $default);

        if (config('app_settings.allow_passthrough_config')) {
            if (!$configValue) {
                $configValue = config($key);
                if (config('app_settings.exception_on_nodefined_config')) {
                    if (is_null($configValue)) {
                        throw new \Exception('Missing config value for ' . $key);
                    }
                }
            }
        }
        return $configValue ;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $val = null)
    {
        // if its an array, batch save settings
        if (is_array($key)) {
            foreach ($key as $name => $value) {
                $this->set($name, $value);
            }

            return true;
        }

        $setting = $this->getSettingModel()->firstOrNew(['name' => $key]);
        $setting->val = $val;
        $setting->save();

        $this->flushCache();

        return $val;
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return $this->all()->has($key);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key)
    {
        $deleted = $this->getSettingModel()->where('name', $key)->delete();

        $this->flushCache();

        return $deleted;
    }

    /**
     * {@inheritdoc}
     */
    public function flushCache()
    {
        return Cache::forget($this->settingsCacheKey);
    }

    /**
     * Get settings eloquent model.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getSettingModel()
    {
        return app('\QCod\Settings\Setting\Setting');
    }
}
