<?php
namespace App\Core\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use App\Core\Components\RoleStructure;
use Permission;

class PrivilegePresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->title = 'Privilege Management';
		$this->role_structure = new RoleStructure();
		$this->view = 'core::pages.privilege';
		$this->permission = Permission::lists();
	}

	public function setSelectedMenuName(){
		return 'privilege';
	}

}