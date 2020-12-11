<?php
namespace App\Core\Http\Traits;

use DB;
use Artisan;
use Schema;

trait InstallerTrait
{
	protected function checkHasInstall(){
		try{
			DB::table('cms_installs')->get();
			return true;
		}catch(\Illuminate\Database\QueryException $e){
			return false;
		}
	}

	protected function createInstallHint(){
		if(!$this->checkHasInstall()){
			//create installation simple table
			Schema::create('cms_installs', function($table){
				$table->datetime('created_at');
			});
			DB::table('cms_installs')->insert([
				'created_at' => date('Y-m-d H:i:s')
			]);
		}
		return false;
	}	

	protected function createUser($username, $email, $password){
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

	
	protected function updateEnv(){
		$env = $this->getEnv();
		$lists = config('module-setting.install.used_env');
		$i = 0;
		foreach($env as $line){
			$saved_line[$i] = $line;
			foreach($lists as $cek){
				if(strpos($line, $cek) !== false){
					if($this->request->{$cek}){
						$val = $this->request->{$cek};
						if(strpos($val, ' ') !== false){
							//append tanda petik kalo ada spasinya
							$val = '"'.$val.'"';
						}
						$saved_line[$i] = $cek.'='.$val;
					}
				}
			}
			$i++;
		}

		//save saved_line to .env
		return $this->saveEnv($saved_line);
	}

	protected function getEnv(){
		try{
			$env_path = base_path('.env');
			$file = fopen($env_path, 'rw');
			$env = fread($file, filesize($env_path));
			$env = explode("\n", $env);

		}catch(\Exception $e){
			$env_path = false;
			$env = [];
		}
		return $env;
	}

	protected function saveEnv($arr){
		try{
			$string = implode("\n", $arr);
			$env_path = base_path(".env");
			file_put_contents($env_path, $string);
		}catch(\Exception $e){
			return false;
		}
		return true;
	}


	protected function checkDatabaseConnection(){
		try{
			//check connection exists
			#will return error if connection failed
			DB::query(DB::raw('SELECT 1'));
		}catch(\Exception $e){
			dd($e);
			return 'Wrong database connection';
		}

		try{
			//check database exists
			#will return error if database not exists
			if(config('database.default') == 'sqlsrv'){
				$cek_database = DB::select("SELECT name FROM master.sys.databases where name='".env('DB_DATABASE')."'");
				if(empty($cek_database)){
					return 'Database not exists';
				}
			}
			else{
				//mysql basic checker
				DB::select('SHOW TABLES');
			}

		}catch(\Exception $e){
			return 'Database not exists';
		}

		return false;
	}

}