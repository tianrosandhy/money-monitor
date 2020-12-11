<?php
namespace App\Core\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use App\Core\Http\Skeleton\UserSkeleton;

class UserCrudPresenter extends BaseViewPresenter
{
	public function __construct($instance=null){
		if(isset($instance->id)){
			$this->title = 'Edit User Data';
		}
		else{
			$this->title = 'Create New User Data';
		}
		$this->data = $instance;
		$this->back_url = route('admin.user.index');
		$this->view = 'core::master.crud';
		$this->skeleton = new UserSkeleton;
		$this->config = config('module-setting.user');
	}

	public function setSelectedMenuName(){
		return 'user';
	}
}