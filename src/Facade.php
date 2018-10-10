<?php

namespace QCod\Settings;

class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'QCod\Settings\Setting\SettingStorage';
    }
}
