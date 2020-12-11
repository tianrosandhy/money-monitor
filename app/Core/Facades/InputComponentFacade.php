<?php
namespace App\Core\Facades;

use Illuminate\Support\Facades\Facade;

class InputComponentFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Components\Input::class;
    }
}
