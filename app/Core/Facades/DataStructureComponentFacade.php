<?php
namespace App\Core\Facades;

use App\Core\Facades\RefreshableFacade;

class DataStructureComponentFacade extends RefreshableFacade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Components\DataTable\DataStructure::class;
    }
}
