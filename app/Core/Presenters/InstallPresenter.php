<?php
namespace App\Core\Presenters;

use App\Core\Presenters\BaseViewPresenter;

class InstallPresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->title = 'Install';
		$this->view = 'core::install';
	}
}