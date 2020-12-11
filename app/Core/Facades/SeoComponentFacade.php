<?php
namespace App\Core\Facades;

use Illuminate\Support\Facades\Facade;

class SeoComponentFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Components\Seo::class;
    }
}
