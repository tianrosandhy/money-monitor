<?php
namespace App\Core\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class CheckInstallation {

    public function handle($request, Closure $next)
    {
		//check if apps is installed
		$installed = true;
		try{
			$check = \DB::table('cms_installs')->get();
		}catch(\Exception $e){
			$installed = false;
		}

		if(!$installed && $request->url() <> url('install')){
			if(env('APP_ENV') == 'local'){
				return redirect()->route('cms.install');		
			}
			else{
				throw new \Exception('Site is still not installed yet');
			}
		}

        return $next($request); 
    }
}

