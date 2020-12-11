<?php
namespace App\Core\Http\Controllers\Partials;

use App\Core\Presenters\BaseViewPresenter;
use App\Core\Http\Process\LoginProcess;
use App\Core\Models\User;
use App\Core\Jobs\ResetPasswordJob;
use App\Core\Http\Process\PasswordResetProcess;
use DB;

trait AuthController
{
	public function login(){
		$p = (new BaseViewPresenter)
			->setTitle('Login')
			->setView('core::pages.login');
		return $p->render();
	}

	public function storeLogin(){
		return (new LoginProcess)->handle();
	}

	public function logout(){
		admin_guard()->logout();
		return redirect(admin_url('/'));
	}

	public function forgotPassword(){
		if(!$this->request->email){
			return back()->with('error', 'Please type your email to send the password reset link');
		}
		$user = User::where('email', $this->request->email)->first();
		if(empty($user)){
			return back()->with('error', 'Sorry, we cannot find your email address in our system.');
		}

		dispatch(new ResetPasswordJob($user));
		return back()->with('success', 'Password reset link has been sent to your email. Please check your email and reset your password');
	}

	public function passwordReset($token){
		$user = $this->getUserByToken($token);
		$title = 'Password Reset';
		return view('core::pages.password-reset', compact(
			'title',
			'user'
		));
	}

	public function passwordResetPost($token){
		$user = $this->getUserByToken($token);
		return (new PasswordResetProcess($user))->handle();

	}

	protected function getUserByToken($token, $abort=true){
		$grab = DB::table('password_resets')->where('token', $token)->first();
		if(isset($grab->email)){
			return User::where('email', $grab->email)->first();
		}
		if($abort){
			abort(404);
		}
		return false;
	}

}