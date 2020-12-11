<?php
namespace App\Core\Components\Sidebar;

use App\Core\Components\Sidebar\SidebarItem;
use App\Core\Exceptions\SidebarException;

// class utk meregistrasikan sidebar modul ke sidebar template
class SidebarRegistration
{
	private $data = [];

	public function __construct(){
		if(method_exists($this, 'handle')){
			$this->handle();
		}
	}

	public function registerSidebar(SidebarItem $item){
		$this->data[] = $item;
	}

	public function registerSidebars($arr=[]){
		foreach($arr as $item){
			if($item instanceof SidebarItem){
				$this->data[] = $item;
			}
			else{
				throw new SidebarException('Invalid parameters. Only SidebarItem class can be registered.');
			}
		}
	}

	public function output(){
		return $this->data;
	}
}