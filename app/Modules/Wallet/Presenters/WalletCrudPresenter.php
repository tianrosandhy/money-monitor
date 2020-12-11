<?php
namespace App\Modules\Wallet\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use DataTable;
use App\Modules\Wallet\Http\Skeleton\WalletSkeleton;

class WalletCrudPresenter extends BaseViewPresenter
{
	public function __construct($instance=null){
		if(isset($instance->id)){
			$this->title = __('wallet::module.edit');
		}
		else{
			$this->title = __('wallet::module.add');
		}
		$this->data = $instance;
		$this->back_url = route('admin.wallet.index');
		$this->view = 'core::master.crud';
		#if you want to override this crud view, you can use below view instead
		// $this->view = 'wallet::crud';

		$this->skeleton = new WalletSkeleton;
		$this->config = config('module-setting.wallet');
	}

	public function setSelectedMenuName(){
		return 'wallet';
	}
}