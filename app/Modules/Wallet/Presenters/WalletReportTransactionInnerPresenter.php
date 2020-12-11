<?php
namespace App\Modules\Wallet\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use App\Modules\Wallet\Models\Wallet;
use WalletInstance;

class WalletReportTransactionInnerPresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->request = request();
		$this->title = 'Wallet Transaction Records';
		$this->view = 'wallet::transaction-inner';
		$this->wallets = Wallet::where('user_id', $this->request->get('user')->id)->orderBy('sort_no', 'ASC')->get(['id', 'title']);
        $this->transactions = WalletInstance::getTransactions([
            'per_page' => 20,
            'page' => $this->request->page,
            'wallets' => $this->request->wallets ?? [],
            'periode' => $this->request->periode ?? [],
        ]);
	}

}