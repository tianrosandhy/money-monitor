<?php
namespace App\Core\Facades;

use Illuminate\Support\Facades\Facade;

class SettingComponentFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Components\Setting::class;
    }
}
