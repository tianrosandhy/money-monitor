<?php
namespace App\Modules\Wallet\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use WalletInstance;

class WalletRecordPresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->request = request();
		$this->title = 'Wallet Records';
		$this->view = 'wallet::record';
		$this->wallet_date = $this->request->wallet_date ? date('Y-m-d', strtotime($this->request->wallet_date)) : date('Y-m-d');
		$this->wallets = WalletInstance::listWallets($this->wallet_date);
		$this->total_wallet = WalletInstance::getTotal($this->wallets, $this->wallet_date);
	}

	public function setSelectedMenuName(){
		return 'wallet-record';
	}

}