<?php
namespace App\Modules\Wallet\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use App\Modules\Wallet\Models\Wallet;

class WalletReportTransactionPresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->request = request();
		$this->title = 'Transaction History';
		$this->view = 'wallet::transaction';
		$this->wallets = Wallet::where('user_id', $this->request->get('user')->id)->orderBy('sort_no', 'ASC')->get(['id', 'title']);
	}

	public function setSelectedMenuName(){
		return 'wallet-transaction';
	}

}