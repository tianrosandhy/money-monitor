<?php
namespace App\Core\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use App\Core\Http\Skeleton\PushNotifSkeleton;
use DataTable;
use Permission;

class PushNotifPresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->title = 'Push Token Device Management';
		$this->view = 'core::pages.push-notif';
		$this->batch_delete_url = route('admin.push-notif.delete');
		$this->skeleton = new PushNotifSkeleton;
		$this->datatable = DataTable::setSkeleton($this->skeleton);

		$this->control_buttons[] = [
			'url' => admin_url('/'),
			'label' => __('core::module.global.back_to_homepage'),
			'icon' => 'home'
		];
		if(Permission::has('admin.push-notif.create')){
			$this->control_buttons[] = [
				'url' => route('admin.push-notif.create'),
				'label' => 'Add Push Token',
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
		return 'push-notif';
	}
}