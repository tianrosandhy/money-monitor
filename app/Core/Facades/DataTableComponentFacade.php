<?php
namespace App\Core\Facades;

use App\Core\Facades\RefreshableFacade;

class DataTableComponentFacade extends RefreshableFacade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Components\DataTable::class;
    }
}
