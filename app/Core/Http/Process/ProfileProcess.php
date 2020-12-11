<?php
namespace App\Core\Http\Process;

use App\Core\Http\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use Validator;

class ProfileProcess extends BaseProcess
{
	public function config(){
		return [
			'error_redirect_target' => route('admin.my-profile'), //ex : url('your-url-when-fail')
			'success_redirect_target' => route('admin.my-profile'), //ex : url('your-url-when-success')
			'success_message' => 'Your profile has been updated successfully',
			'error_message' => null
		];
	}

	public function validate(){
		$validate = Validator::make($this->request->all(), [
			'name' => "required|max:50",
			'email' => 'required|unique:users,email,'.$this->request->get('user')->id,
			'password' => 'nullable|confirmed|min:6'
		]);

		if($validate->fails()){
			throw new ProcessException($validate);
		}
	}

	public function process(){
		if(env('APP_DEMO')){
			$this->setSuccessMessage('Success. But this action is disabled in demo mode');
			return true;
		}

		//your logic after validation success
		$user = $this->request->get('user');
		$user->name = $this->request->name;
		$user->email = $this->request->email;
		$user->image = $this->request->image;
		if($this->request->password){
			$user->password = bcrypt($this->request->password);
		}
		$user->save();
	}

	public function revert(){
		//your logic when validation or process failed to running
	}


}