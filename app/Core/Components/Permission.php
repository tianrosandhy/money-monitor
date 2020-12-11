<?php
namespace App\Core\Components;

use Str;

class Permission
{
	public function __construct(){
		$this->config = config('permission');
		$this->role = $this->getCurrentRole();
	}

	public function all(){
		return $this->config;
	}

	public function lists(){
		$out = [];
		foreach($this->config as $group => $lists){
			foreach($lists as $sub => $items){
				$out = array_merge($out, $items);
			}
		}
		return array_unique($out);
	}

	public function has($permission_key=null, $role=null){
		if(in_array($permission_key, $this->lists())){
			if($this->role->is_sa){
				//superadmin selalu punya akses ke segala halaman
				return true;
			}
			else{
				//cek permission si role ybs
				$current_role_permissions = json_decode($this->role->priviledge_list, true);
				if(!$current_role_permissions){
					//jika gagal diparsing, anggap role ybs tidak punya akses 
					return false;
				}
				//return true if has permission, and return false if not have permission
				return in_array($permission_key, $current_role_permissions);
			}
		}

		//if permission is not in config lists, then everyone can access
		return true;
	}

	protected function getCurrentRole($role_id=null){
		if($role_id){
			return app('role')->where('id', $role_id)->first();
		}
		else{
			return request()->get('role');
		}
	}
}