<?php
namespace App\Core\Facades;

use Illuminate\Support\Facades\Facade;

class LanguageComponentFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Components\Language::class;
    }
}
