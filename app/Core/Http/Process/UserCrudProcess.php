<?php
namespace App\Core\Http\Process;

use App\Core\Http\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use App\Core\Http\Skeleton\UserSkeleton;
use Validator;

class UserCrudProcess extends BaseProcess
{
	public function __construct($instance=null){
		parent::__construct();
		if(isset($instance->id)){
			$this->mode = 'update';
		}
		else{
			$this->mode = 'create';
		}
		$this->instance = $instance;
		$this->skeleton = new UserSkeleton;
	}


	public function config(){
		return [
			'error_redirect_target' => null, //ex : url('your-url-when-fail')
			'success_redirect_target' => route('admin.user.index'), //ex : url('your-url-when-success')
			'success_message' => 'Your data has been saved successfully',
			'error_message' => null
		];
	}

	public function validate(){
		$validator = $this->skeleton->generateValidation($this->mode);
		if($validator){
			if($validator->fails()){
				throw new ProcessException($validator);
			}
		}

		//tambahan validasi jika dalam kondisi update + ganti password
		if($this->mode == 'update' && $this->request->password){
			$validator = Validator::make($this->request->all(), [
				'password' => 'required|confirmed|min:6'
			]);
			if($validator->fails()){
				throw new ProcessException($validator);
			}
		}
		// dd($this->request->all());
	}

	public function process(){
		//your logic after validation success
		$skeleton_inputs = $this->skeleton->autoCrud();
		if(!empty($skeleton_inputs)){
			//create new instance if not exists, but use selected instance if exists
			$instance = $this->instance ?? $this->skeleton->model();
			foreach($skeleton_inputs as $field => $value){
				//gausah ubah password dalam mode update jika tidak diperlukan
				if($this->mode == 'update' && $field == 'password' && empty($value)){
					continue;
				}
				if($field == 'password'){
					$value = bcrypt($value);
				}

				$instance->{$field} = $value;
			}
			$instance->save();
		}
		if($this->request->save_only){
			$this->setSuccessRedirectTarget(route('admin.user.edit', ['id' => $instance->id]));
		}

		// if you have another logic for storing data that doesnt cover by Skeleton, you can define them here.
	}

	public function revert(){
		//your logic when validation or process failed to running
	}


}