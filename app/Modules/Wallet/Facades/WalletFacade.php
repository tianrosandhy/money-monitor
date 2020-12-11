<?php
namespace App\Modules\Wallet\Facades;

use Illuminate\Support\Facades\Facade;

class WalletFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Modules\Wallet\Services\WalletInstance::class;
    }
}
