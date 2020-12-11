<?php
namespace App\Core\Http\Controllers;

use App\Core\Presenters\InstallPresenter;
use App\Core\Http\Process\InstallProcess;
use App\Core\Http\Traits\InstallerTrait;

class InstallController extends BaseController
{
	use InstallerTrait;

	public function index(){
		$p = new InstallPresenter;
		$p->setHasInstall($this->checkHasInstall());
		$p->setDb($this->checkDatabaseConnection());
		$p->setEnv($this->getEnv());
		return $p->render();
	}

	public function process(){
		$process = new InstallProcess();
		$process->type('http');
		return $process->handle();
	}



}