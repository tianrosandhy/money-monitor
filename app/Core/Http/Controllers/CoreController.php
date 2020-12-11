<?php
namespace App\Core\Http\Controllers;

use App\Core\Http\Controllers\BaseController;
use App\Core\Presenters\BaseViewPresenter;
use App\Core\Http\Process\SettingProcess;

class CoreController extends BaseController
{
	use Partials\AuthController;
	use Partials\ProfileController;
	use Partials\LanguageController;
	use Partials\PrivilegeController;
	use Partials\UserManagementController;
	use Partials\LogController;
	use Partials\PushNotifController;

	public function index(){
		return redirect()->route('admin.wallet-record.report');
	}

	public function storeSetting(){
		return (new SettingProcess)->handle();
	}


}