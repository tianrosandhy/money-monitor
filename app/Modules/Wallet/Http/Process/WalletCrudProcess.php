<?php
namespace App\Modules\Wallet\Http\Process;

use App\Core\Http\Process\BaseCrudProcess;
use App\Modules\Wallet\Http\Skeleton\WalletSkeleton;

class WalletCrudProcess extends BaseCrudProcess
{
	public function setSkeleton(){
		return new WalletSkeleton;
	}

	public function config(){
		return [
			'error_redirect_target' => null, //ex : url('your-url-when-fail')
			'success_redirect_target' => route('admin.wallet.index'), //ex : url('your-url-when-success')
			'success_message' => 'Your data has been saved successfully',
			'error_message' => null
		];
	}

	public function afterCrud($instance){
		$instance->user_id = $this->request->get('user')->id;
		$instance->save();
		if(!$instance->sort_no){
			$instance->sort_no = 999;
			$instance->save();
		}
	}

}