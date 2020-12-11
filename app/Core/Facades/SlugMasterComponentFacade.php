<?php
namespace App\Core\Facades;

use Illuminate\Support\Facades\Facade;

class SlugMasterComponentFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Components\SlugMaster::class;
    }
}
