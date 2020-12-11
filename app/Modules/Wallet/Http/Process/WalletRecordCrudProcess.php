<?php
namespace App\Modules\Wallet\Http\Process;

use App\Core\Http\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use App\Modules\Wallet\Models\Wallet;
use Validator;
use WalletInstance;

class WalletRecordCrudProcess extends BaseProcess
{
	public function config(){
		return [
			'error_redirect_target' => null, //ex : url('your-url-when-fail')
			'success_redirect_target' => null, //ex : url('your-url-when-success')
			'success_message' => 'Your data has been saved successfully',
			'error_message' => null
		];
	}

	public function validate(){
		$validate = Validator::make($this->request->all(), [
			'tanggal' => 'required|date',
			'nominal' => 'required',
			'wallet_id' => 'required'
		]);

		if($validate->fails()){
			throw new ProcessException($validate);
		}
	}

	public function process(){
		$data = Wallet::findOrFail($this->request->wallet_id);
		$wrecord = WalletInstance::addRecord([
			'tanggal' => date('Y-m-d', strtotime($this->request->tanggal)),
			'nominal' => intval($this->request->nominal),
			'wallet_id' => $data->id,
			'user_id' => $this->request->get('user')->id,
		]);
		return true;
	}

}