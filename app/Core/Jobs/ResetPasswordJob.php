<?php
namespace App\Core\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Core\Models\User;
use App\Core\Mail\BaseMail;
use DB;
use Log;
use Mail;

class ResetPasswordJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable;

	public function __construct(User $user){
		$this->user = $user;
	}


	public function handle(){
		$email = $this->user->email;

		//hapus token lama jika ada
		$check_old_password_reset = DB::table('password_resets')->where('email', $email)->count();
		if($check_old_password_reset > 0){
			DB::table('password_resets')->where('email', $email)->delete();
		}

		$token = sha1(encrypt($this->user->email . '|' . time()));
		DB::table('password_resets')->insert([
			'email' => $email,
			'token' => $token,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		]);

		$mail = new BaseMail;
		$mail->setSubject('Password Reset for '.setting('site.title').' Admin Account');
		$mail->setTitle('Account Recovery');
		$mail->setContent("<p>Hi ".$this->user->name.", we just receive your account password reset request. Please click the password reset link below to set new password to your email so you can start login again. If you dont make such request, you can ignore this email. \nHave a nice day..</p>");
		$mail->setButton([
			'url' => route('admin.password-reset', ['token' => $token]),
			'label' => 'Reset Your Password Now'
		]);
		Mail::to($this->user->email)->send($mail);
		Log::info('MAIL PASSWORD RESET LINK HAS BEEN SENT TO ' . $this->user->email);
	}

}