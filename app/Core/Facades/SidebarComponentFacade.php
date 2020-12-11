<?php
namespace App\Core\Facades;

use Illuminate\Support\Facades\Facade;

class SidebarComponentFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Components\Sidebar::class;
    }
}
