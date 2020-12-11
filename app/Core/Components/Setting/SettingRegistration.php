<?php
namespace App\Core\Components\Setting;

use App\Core\Components\Setting\SettingGroup;
use App\Core\Components\Setting\SettingItem;

// class utk meregistrasikan data setting modul ke Setting Template
class SettingRegistration
{
	public $groups = [];

	public function __construct(){
		if(method_exists($this, 'handle')){
			$this->handle();
		}
	}

	public function addSettingGroup($group_name, $items, $order=null){
		if(isset($this->groups[$group_name])){
			if($items instanceof SettingItem){
				$this->groups[$group_name]->addItem($items);
			}
			else if(is_array($items)){
				$this->groups[$group_name]->addItems($items);
			}
		}
		else{
			$sg = new SettingGroup($group_name, $items);
			if($order){
				$sg->setOrder($order);
			}
			$this->groups[$group_name] = $sg;
		}
	}

	public function output(){
		return collect($this->groups);
	}
}