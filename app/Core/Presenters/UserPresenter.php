<?php
namespace App\Core\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use App\Core\Http\Skeleton\UserSkeleton;
use DataTable;
use Permission;

class UserPresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->title = 'User Management';
		$this->view = 'core::master.index';
		$this->batch_delete_url = route('admin.user.delete');
		$this->skeleton = new UserSkeleton;
		$this->datatable = DataTable::setSkeleton($this->skeleton);

		$this->control_buttons[] = [
			'url' => admin_url('/'),
			'label' => __('core::module.global.back_to_homepage'),
			'icon' => 'home'
		];
		if(Permission::has('admin.user.create')){
			$this->control_buttons[] = [
				'url' => route('admin.user.create'),
				'label' => __('core::module.form.add_data'),
				'type' => 'success',
				'icon' => 'plus'
			];
		}
		$this->control_buttons[] = [
			'label' => 'Filter',
			'icon' => 'filter',
			'type' => 'primary',
			'attr' => [
				'data-toggle' => 'collapse',
				'data-target' => '#searchBox-' . $this->skeleton->name()
			]
		];
	}

	public function setSelectedMenuName(){
		return 'user';
	}
}