<?php
namespace App\Core\Presenters;

use App\Core\Presenters\BaseViewPresenter;

class RegisterPresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->title = 'Register';
		$this->view = 'core::register';
	}
}