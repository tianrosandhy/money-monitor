<?php
namespace App\Core\Http\Controllers\Partials;

use App\Core\Presenters\BaseViewPresenter;
use App\Core\Http\Process\ProfileProcess;

trait ProfileController
{
	public function myProfile(){
		$p = (new BaseViewPresenter)
			->setTitle('My Profile')
			->setView('core::pages.my-profile');
		return $p->render();
	}

	public function storeMyProfile(){
		return (new ProfileProcess)->handle();
	}	
}