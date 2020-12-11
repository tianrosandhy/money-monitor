<?php
namespace App\Modules\Wallet\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use App\Modules\Wallet\Models\Wallet;
use WalletInstance;

class WalletReportPresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->title = 'Wallet Report';
		$this->view = 'wallet::report';
		$this->request = request();

		$this->start_date = $this->request->periode[0] ?? date('Y-m-d', strtotime('-7 days'));
		$this->end_date = $this->request->periode[1] ?? date('Y-m-d');

		$this->report = WalletInstance::generateReport($this->start_date, $this->end_date);
		$this->wallets = Wallet::where('user_id', $this->request->get('user')->id)->get();
	}

	public function setSelectedMenuName(){
		return 'wallet-report';
	}

}