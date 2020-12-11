<?php
namespace App\Modules\Wallet\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use WalletInstance;

class WalletRecordPresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->title = 'Wallet Records';
		$this->view = 'wallet::record';
		$this->wallets = WalletInstance::listWallets();
		$this->total_wallet = WalletInstance::getTotal($this->wallets);
	}

	public function setSelectedMenuName(){
		return 'wallet-record';
	}

}