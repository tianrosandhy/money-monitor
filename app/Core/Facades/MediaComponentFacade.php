<?php
namespace App\Core\Facades;

use Illuminate\Support\Facades\Facade;

class MediaComponentFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Components\Media::class;
    }
}
