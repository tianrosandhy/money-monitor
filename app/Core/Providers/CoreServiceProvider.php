<?php
namespace App\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Validator;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Database\Schema\Builder;
use App\Core\Models\Setting;
use App\Core\Models\Role;
use App\Core\Models\Language;

class CoreServiceProvider extends BaseServiceProvider{
	protected $namespace = 'App\Core\Http\Controllers';

	public function boot(){
		Builder::defaultStringLength(191);
		$this->loadMigrationsFrom(realpath(__DIR__."/../Migrations"));
		$this->loadTranslationsFrom(__DIR__ . '/../Translations', 'core');
	}

	public function register(){
		$this->loadHelpers(__DIR__.'/..');
		$this->mapping($this->app->router);
		$this->loadViewsFrom(realpath(__DIR__."/../Views"), 'core');
		$this->loadModules();
		$this->mergeMainConfig();
		$this->registerAlias();
		$this->registerContainer();
	}

	protected function mergeMainConfig(){
		$this->mergeConfigFrom(
		    __DIR__.'/../Configs/module-setting.php', 'module-setting'
		);
		$this->mergeConfigFrom(
		    __DIR__.'/../Configs/permission.php', 'permission'
		);
		$this->mergeConfigFrom(
		    __DIR__.'/../Configs/image.php', 'image'
		);
	}


	protected function mapping(Router $router){
		$router->group([
			'namespace' => $this->namespace, 
			'middleware' => [
				'backend', 
			]
		], function($router){
			$router->group(['prefix' => admin_prefix()], function(){
				require realpath(__DIR__."/../Routes/web.php");
				require realpath(__DIR__."/../Routes/api.php");
				require realpath(__DIR__."/../Routes/testing.php");
			});
		});
		
		$router->group([
			'namespace' => $this->namespace, 
			'middleware' => [
				'backend_guest', 
			]
		], function($router){
			$router->group(['prefix' => admin_prefix()], function(){
				require realpath(__DIR__."/../Routes/public.php");
			});
		});
		

		$router->group([
			'namespace' => $this->namespace, 
			'prefix' => 'install',
			'middleware' => [
				'web'
			]
		], function($router){
			require realpath(__DIR__."/../Routes/install.php");
		});
	}

	public function registerContainer(){
		$this->app->singleton('setting', function($app){
			return Setting::get();
		});
		$this->app->singleton('language', function($app){
			return Language::get();
		});
		$this->app->singleton('role', function($app){
			return Role::with('owner', 'children')->get();
		});
	}


	protected function loadModules(){
	    $listModule = config('modules.load');
	    if($listModule){
		    foreach($listModule as $mod){
		    	try{
			    	if(class_exists($mod)){
					    $this->app->register($mod);
			    	}
		    	}catch(\Exception $e){
		    		//any error in registering the class will be ignored
		    	}
		    }
	    }
	}	

	protected function registerAlias(){
		//automatically load alias
		$aliasData = [
		    'Input' => \App\Core\Facades\InputComponentFacade::class,
		    'Setting' => \App\Core\Facades\SettingComponentFacade::class,
		    'Media' => \App\Core\Facades\MediaComponentFacade::class,
		    'Sidebar' => \App\Core\Facades\SidebarComponentFacade::class,
		    'SidebarItem' => \App\Core\Facades\SidebarItemComponentFacade::class,
		    'DataStructure' => \App\Core\Facades\DataStructureComponentFacade::class,
		    'DataTable' => \App\Core\Facades\DataTableComponentFacade::class,
		    'Permission' => \App\Core\Facades\PermissionComponentFacade::class,
		    'Language' => \App\Core\Facades\LanguageComponentFacade::class,
		    'SlugMaster' => \App\Core\Facades\SlugMasterComponentFacade::class,
		    'SEO' => \App\Core\Facades\SeoComponentFacade::class,
		    'ColumnListing' => \App\Core\Facades\ColumnListingComponentFacade::class,
		];

		foreach($aliasData as $al => $src){
			AliasLoader::getInstance()->alias($al, $src);
		}
	}
}