<?php
namespace App\Core\Http\Process;

use App\Core\Http\Traits\ThrottlesLogin;
use App\Core\Http\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use Validator;

class LoginProcess extends BaseProcess
{
	use ThrottlesLogin;

	public function config(){
		return [
			'error_redirect_target' => route('admin.login'), //ex : url('your-url-when-fail')
			'success_redirect_target' => admin_url('/'), //ex : url('your-url-when-success')
			'success_message' => 'Your have logged in successfully',
			'error_message' => null
		];
	}

	public function validate(){
		$validate = Validator::make($this->request->all(), [
			'email' => 'required|email',
			'password' => 'required'
		]);

		if($validate->fails()){
			throw new ProcessException($validate);
		}

        if ($this->hasTooManyLoginAttempts($this->request)) {
            $this->fireLockoutEvent($this->request);
            throw new ProcessException('Sorry, you are blocked for security reason. Please contact the administrator for the support');
        }
	}

	public function process(){
		//your logic after validation success
        $login = admin_guard()->attempt([
        	'email' => $this->request->email,
        	'password' => $this->request->password
        ], $this->request->filled('remember'));
        if(!$login){
        	throw new ProcessException('Invalid username or password. Please try again');
        }
        $this->clearLoginAttempts($this->request);
	}

	public function revert(){
		//your logic when validation or process failed to running
	}


}