<?php
namespace App\Modules\Wallet\Http\Process;

use App\Core\Http\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use App\Modules\Wallet\Models\WalletRecord;
use Validator;

class WalletRecordDeleteProcess extends BaseProcess
{
	public function config(){
		return [
			'error_redirect_target' => null, //ex : url('your-url-when-fail')
			'success_redirect_target' => null, //ex : url('your-url-when-success')
			'success_message' => 'Your wallet record has been deleted successfully',
			'error_message' => null
		];
	}

	public function validate(){
		$validate = Validator::make($this->request->all(), [
			'id' => 'required|numeric',
		]);

		if($validate->fails()){
			throw new ProcessException($validate);
		}
	}

	public function process(){
        $check = WalletRecord::where('id', $this->request->id)
            ->where('user_id', $this->request->get('user')->id)
            ->first();

        if(!$check){
            throw new ProcessException('Wallet data not found');
        }
        
        $check->delete();
		return true;
	}

}