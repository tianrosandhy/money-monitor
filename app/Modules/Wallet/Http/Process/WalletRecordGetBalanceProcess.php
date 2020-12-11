<?php
namespace App\Modules\Wallet\Http\Process;

use App\Core\Http\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use App\Modules\Wallet\Models\Wallet;
use Validator;
use WalletInstance;

class WalletRecordGetBalanceProcess extends BaseProcess
{
	public function config(){
		return [
			'error_redirect_target' => null, //ex : url('your-url-when-fail')
			'success_redirect_target' => null, //ex : url('your-url-when-success')
			'success_message' => 'Here is your balance data',
			'error_message' => null
		];
	}

	public function validate(){
		$validate = Validator::make($this->request->all(), [
			'date' => 'required|date',
			'wallet_id' => 'required'
		]);

		if($validate->fails()){
			throw new ProcessException($validate);
		}
	}

	public function process(){
		$data = Wallet::findOrFail($this->request->wallet_id);
        $balance = WalletInstance::getWalletBalance($data, $this->request->date);
		return [
			'balance' => $balance,
			'formatted_balance' => number_format($balance)
		];
	}

}