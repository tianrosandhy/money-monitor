<?php
namespace App\Core\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use App\Core\Http\Skeleton\PushNotifSkeleton;

class PushNotifCrudPresenter extends BaseViewPresenter
{
	public function __construct($instance=null){
		if($instance){
			$this->title = 'Edit Push Token Device Data';
		}
		else{
			$this->title = 'Create New Push Token Device Data';
		}
		$this->data = $instance;
		$this->back_url = route('admin.push-notif.index');
		$this->view = 'core::master.crud';
		$this->skeleton = new PushNotifSkeleton;
		$this->config = config('module-setting.push-notif');
	}

	public function setSelectedMenuName(){
		return 'push-notif';
	}
}