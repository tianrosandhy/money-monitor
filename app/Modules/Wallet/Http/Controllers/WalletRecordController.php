<?php
namespace App\Modules\Wallet\Http\Controllers;

use App\Core\Http\Controllers\BaseController;
use App\Modules\Wallet\Models\Wallet;
use App\Modules\Wallet\Models\WalletRecord;
use App\Modules\Wallet\Presenters\WalletRecordPresenter;
use App\Modules\Wallet\Presenters\WalletRecordCrudPresenter;
use App\Modules\Wallet\Presenters\WalletReportPresenter;
use App\Modules\Wallet\Presenters\WalletReportTransactionPresenter;
use App\Modules\Wallet\Presenters\WalletReportTransactionInnerPresenter;
use App\Modules\Wallet\Http\Process\WalletRecordCrudProcess;
use App\Modules\Wallet\Http\Process\WalletRecordGetBalanceProcess;
use App\Modules\Wallet\Http\Process\WalletRecordDeleteProcess;

class WalletRecordController extends BaseController
{
    public function index(){
        return (new WalletRecordPresenter)->render();
    }

    public function create($wallet_id=null){
        $wallet = Wallet::findOrFail($wallet_id);
        return (new WalletRecordCrudPresenter($wallet))->render();
    }

    public function store($wallet_id=null){
        return (new WalletRecordCrudProcess)
            ->type('ajax')
            ->handle();
    }

    public function getBalance(){
        return (new WalletRecordGetBalanceProcess)
            ->type('ajax')
            ->handle();
    }

    public function report(){
        return (new WalletReportPresenter)->render();
    }

    public function transaction(){
        return (new WalletReportTransactionPresenter)->render();
    }

    public function getTransactionList(){
        return (new WalletReportTransactionInnerPresenter)->render();
    }

    public function removeWalletRecord(){
        return (new WalletRecordDeleteProcess)
            ->type('ajax')
            ->handle();
    }
}