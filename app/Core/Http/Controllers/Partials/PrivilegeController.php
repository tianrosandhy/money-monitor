<?php
namespace App\Core\Http\Controllers\Partials;

use App\Core\Presenters\PrivilegePresenter;
use App\Core\Components\RoleStructure;
use App\Core\Models\Role;
use Permission;

trait PrivilegeController
{
	public function privilege(){
		return (new PrivilegePresenter)->render();
	}

	public function privilegeCreate(){
		$data = new Role;
		$structure = new RoleStructure;
		$target = route('admin.privilege.store');
		return view('core::pages.partials.privilege-crud', compact(
			'data',
			'structure',
			'target'
		));
	}

	public function privilegeStore(){
		return (new \App\Core\Http\Process\PrivilegeCrudProcess)
			->handle();
	}

	public function privilegeEdit($id){
		$data = app('role')->where('id', $id)->first();
		if(empty($data)){
			abort(404);
		}
		$structure = new RoleStructure;
		$target = route('admin.privilege.update', ['id' => $id]);
		return view('core::pages.partials.privilege-crud', compact(
			'data',
			'structure',
			'target'
		));
	}

	public function privilegeUpdate($id){
		$data = app('role')->where('id', $id)->first();
		if(empty($data)){
			abort(404);
		}
		return (new \App\Core\Http\Process\PrivilegeCrudProcess($data))
			->handle();

	}

	public function privilegeDelete($id){
		$structure = new RoleStructure;
		$available_role = $structure->array_only;
		if(!in_array($id, $available_role)){
			return [
				'type' => 'error',
				'message' => 'Action forbidden'
			];
		}

		$role_will_be_deleted = app('role')->where('id', $id)->first();
		if($role_will_be_deleted->is_sa){
			return [
				'type' => 'error',
				'message' => 'You cannot delete this superadmin role'
			];
		}

		//sebelum hapus, pastikan anak2nya tetap dalam kondisi terurus
		$anak2list = $role_will_be_deleted->children;
		$owner = $role_will_be_deleted->owner;

		if(!empty($owner)){
			$update_owner_to = $owner->id;
		}
		else{
			$update_owner_to = null;
		}

		foreach($anak2list as $anak){
			$anak->role_owner = $update_owner_to;
			$anak->save();
		}
		
		$role_will_be_deleted->delete();		

		return [
			'type' => 'success',
			'message' => 'Privilege has been deleted successfully'
		];
	}

	public function privilegeManage($id){
		$data = app('role')->where('id', $id)->first();
		if(empty($data)){
			abort(404);
		}
		$target = route('admin.privilege.store-manage', ['id' => $id]);
		$all = Permission::all();
		$checked = json_decode($data->priviledge_list, true);
		if(!$checked){
			$checked = [];
		}
		return view('core::pages.partials.privilege-management', compact(
			'data',
			'target',
			'all',
			'checked'
		));
	}

	public function privilegeStoreManage($id){
		$data = app('role')->where('id', $id)->first();
		if(empty($data)){
			abort(404);
		}

		$permission_string = '';
		if(is_array($this->request->check)){
			$permission_string = json_encode($this->request->check);
		}
		$data->priviledge_list = $permission_string;
		$data->save();
		return redirect()->route('admin.privilege.index')->with('success', 'The privilege data has been saved for role "'.$data->name.'"');
	}



}