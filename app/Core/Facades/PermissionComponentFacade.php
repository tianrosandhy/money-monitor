<?php
namespace App\Core\Facades;

use Illuminate\Support\Facades\Facade;

class PermissionComponentFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Components\Permission::class;
    }
}
