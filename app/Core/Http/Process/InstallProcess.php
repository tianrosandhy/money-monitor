<?php
namespace App\Core\Http\Process;

use App\Core\Http\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use App\Core\Http\Traits\InstallerTrait;
use Validator;
use Artisan;
use DB;

class InstallProcess extends BaseProcess
{
	use InstallerTrait;

	public function config(){
		return [
			'error_redirect_target' => route('cms.install'),
			'success_redirect_target' => admin_url('/'),
			'success_message' => 'Your site has been installed successfully',
			'error_message' => null
		];
	}

	public function validate(){
		Artisan::call('migrate');
		//validation process
		$validator = Validator::make($this->request->all(), [
			'name' => 'required',
			'email' => 'required|email|unique:users',
			'password' => 'required|confirmed|min:6'
		]);

		if($validator->fails()){
			throw new ProcessException($validator);
		}
	}

	public function process(){
		$db = $this->checkDatabaseConnection();
		if($db){
			//check if has database config has changed parameters
			$env = $this->updateEnv();
			if($env){
				$this->setSuccessMessage('File .env has been updated.');
				return true;
			}
			else{
				throw new ProcessException('Please update the .env file manually before you can continue install this CMS');
			}
		}

		$this->installAction();

        $this->setSuccessMessage('CMS Installation has been finished. Now you can use this CMS');
        return true;
	}

	public function installAction(){
        $this->createUser($this->request->email, $this->request->name, $this->request->password);
        Artisan::call('autocrud:role');
        $this->createInstallHint();
	}

    protected function createUser($email, $username, $password){
        DB::table('users')->insert([
            'name' => $username,
            'email' => $email,
            'password' => bcrypt($password),
            'role_id' => 1, //default
            'image' => '',
            'activation_key' => null,
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

}