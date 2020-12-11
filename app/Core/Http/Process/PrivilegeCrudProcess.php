<?php
namespace App\Core\Http\Process;

use App\Core\Http\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use Validator;
use App\Core\Models\Role;

class PrivilegeCrudProcess extends BaseProcess
{
	public function __construct($instance=null){
		parent::__construct();
		$this->instance = $instance;
	}

	public function config(){
		return [
			'error_redirect_target' => null, //ex : url('your-url-when-fail')
			'success_redirect_target' => null, //ex : url('your-url-when-success')
			'success_message' => 'Your privilege has been saved successfully',
			'error_message' => null
		];
	}

	public function validate(){
		$filter['name'] = 'required';
		if($this->instance){
			$filter['role_owner'] = 'notin:' . $this->instance->id;
		}
		$validate = Validator::make($this->request->all(), $filter, [
			'role_owner.notin' => 'You cannot add the same role as owner'
		]);

		if($validate->fails()){
			throw new ProcessException($validate);
		}


		if($this->request->role_owner && isset($this->instance->id)){
			$role_target = app('role')->where('id', $this->request->role_owner)->first();
			$owners = $role_target->owners();
			if(in_array($this->instance->id, $owners)){
				throw new ProcessException('You cannot set this role as children of this role');
			}
		}
	}

	public function process(){
		if(!$this->instance){
			$this->instance = new Role;
		}

		$role_owner = $this->request->role_owner;
		if(!$this->request->get('is_sa') && !$this->request->role_owner && $this->instance->id <> $this->request->get('user')->id){
			//in case yg insert privilege bukan admin, set role_owner ke dirinya sendiri
			$role_owner = $this->request->get('user')->id;
		}

		$this->instance->name = $this->request->name;
		if(!$this->instance->is_sa){
			$this->instance->role_owner = $role_owner;
		}
		$this->instance->save();
	}

	public function revert(){
		//your logic when validation or process failed to running
	}


}