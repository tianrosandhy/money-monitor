<?php
namespace App\Core\Facades;

use App\Core\Facades\RefreshableFacade;

class SidebarItemComponentFacade extends RefreshableFacade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Components\Sidebar\SidebarItem::class;
    }
}
