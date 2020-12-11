<?php
namespace App\Core\Http\Skeleton;

use DataStructure;
use DataSource;
use App\Core\Http\Skeleton\BaseSkeleton;
use App\Core\Models\UserPushToken;
use App\Core\Models\User;
use Media;
use Permission;

class PushNotifSkeleton extends BaseSkeleton
{
	public function handle(){
		$this->registers([
			DataStructure::checker(),
			DataStructure::field('user_id')
				->name('User')
				->inputType('select')
                ->dataSource(function(){
                    $list = User::get(['id', 'name'])->pluck('name', 'id');
                    return $list->toArray();
                })
				->createValidation('required|max:50', true),
			DataStructure::field('device_name')
				->name('Device Name'),
			DataStructure::field('push_token')
				->name('Push Token'),
			DataStructure::switcher('is_active', 'Is Active', 6),
		]);
	}

	public function dataTableRoute(){
		return route('admin.push-notif.datatable');
	}

	public function model(){
		return UserPushToken::with('user');
	}

	public function rowFormat($row){
		return [
			'id' => $this->checkerFormat($row),
			'user_id' => $row->user->name ?? '-',
			'device_name' => substr($row->device_name, 0, 50).'...',
			'push_token' => '<input type="text" class="form-control" value="'.$row->push_token.'">',
			'is_active' => $this->switcherFormat($row, 'is_active', (Permission::has('admin.push-notif.switch') ? 'toggle' : 'label')),
			'action' => $this->actionButton($row)
		];
	}

	protected function actionButton($row){
		$out = '
		<div class="btn-group">
		';
		if(Permission::has('admin.push-notif.edit'))
		$out .= '<a href="'.route('admin.push-notif.edit', ['id' => $row->id]).'" class="btn btn-info">Edit</a>';

		$is_sa = $row->role->is_sa ?? false;
		if(!$is_sa){
			if(Permission::has('admin.push-notif.delete')){
				$out .= '
				<a href="'. route('admin.push-notif.delete', ['id' => $row->id]) .'" class="btn btn-danger delete-button">'. __('core::module.form.delete') .'</a>
				';
			}
		}
		$out .= '</div>';

		return $out;
	}
}