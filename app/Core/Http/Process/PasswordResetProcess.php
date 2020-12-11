<?php
namespace App\Core\Http\Process;

use App\Core\Http\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use Validator;
use App\Core\Models\User;
use DB;

class PasswordResetProcess extends BaseProcess
{
	public function __construct(User $user){
		parent::__construct();
		$this->user = $user;
	}

	public function config(){
		return [
			'error_redirect_target' => null, //ex : url('your-url-when-fail')
			'success_redirect_target' => route('admin.login'), //ex : url('your-url-when-success')
			'success_message' => 'Your password has been updated successfully. You can login with your new password now',
			'error_message' => null
		];
	}

	public function validate(){
		$validate = Validator::make($this->request->all(), [
			'password' => 'required|min:6|confirmed'
		]);

		if($validate->fails()){
			throw new ProcessException($validate);
		}
	}

	public function process(){
		//update password
		$this->user->password = bcrypt($this->request->password);
		$this->user->save();

		//remove password_resets
		DB::table('password_resets')->where('email', $this->user->email)->delete();
	}

	public function revert(){
		//your logic when validation or process failed to running
	}


}