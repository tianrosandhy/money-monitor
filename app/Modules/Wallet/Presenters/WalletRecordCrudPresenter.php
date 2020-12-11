<?php
namespace App\Modules\Wallet\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use WalletInstance;

class WalletRecordCrudPresenter extends BaseViewPresenter
{
	public function __construct($wallet){
		$this->request = request();
		$this->title = $wallet->title . ' Wallet Records';
		$this->view = 'wallet::crud';
		$this->wallet = $wallet;
		$this->tanggal = $this->request->tanggal ? date('Y-m-d', strtotime($this->request->tanggal)) : date('Y-m-d');
		$this->wallet_balance = WalletInstance::getWalletBalance($this->wallet, $this->tanggal);
	}

}