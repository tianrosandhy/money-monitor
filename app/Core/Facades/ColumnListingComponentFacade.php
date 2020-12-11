<?php
namespace App\Core\Facades;

use Illuminate\Support\Facades\Facade;

class ColumnListingComponentFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Components\ColumnListing::class;
    }
}
