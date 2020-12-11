<?php
namespace App\Core\Components;

use App\Core\Models\Setting as Model;
use Media;

class Setting
{
	public 
		$data = [],
		$formatted = [];

	public function __construct(){
		$this->db_setting = app('setting');
		$this->loadSettingRegistrations();
		$this->setSettingValueFromDb();
		$this->formattedOutput();
	}

	public function all(){
		return $this->formatted;
	}

	public function get($key, $fallback=null){
		$key = strtolower($key);
		$value = $this->formatted[$key] ?? null;

		//try decode, to check that the value is image
		$decode = json_decode($value, true);
		if($decode){
			if(isset($decode['id']) && isset($decode['thumb'])){
				return Media::getSelectedImage($value);
			}
		}
		return $value ?? $fallback;
	}

	public function data(){
		return collect($this->data)->sortBy('order');
	}

	public function insert($param){
		return Model::insert($param);
	}

	public function loadSettingRegistrations(){
		$reg_suffix = 'Extenders\\SettingGenerator';
		$lists = config('modules.load');
		if(empty($lists)){
			$lists = [];
		}

		$lists = array_map(function($item) use($reg_suffix){
			$split = explode('Providers\\', $item);
			return $split[0] . $reg_suffix;
		}, $lists);
		$lists = array_merge(['\\App\\Core\\' . $reg_suffix], $lists);

		//load class lists
		foreach($lists as $class_name){
			if(!class_exists($class_name)){
				continue;
			}
			$generator = app($class_name);
			foreach($generator->output() as $group_key => $setting_lists){
				$this->data[$group_key]['order'] = $setting_lists->getOrder();
				$this->data[$group_key]['title'] = ucwords($group_key);
				if(isset($this->data[$group_key]['items'])){
					$this->data[$group_key]['items'] = array_merge($this->data[$group_key]['items'], $setting_lists->getItems());
				}
				else{
					$this->data[$group_key]['items'] = $setting_lists->getItems();
				}
			}
		}
	}

	public function setSettingValueFromDb(){
		foreach($this->data as $group_name => $lists){
			foreach($lists['items'] as $item){
				$grab = $this->db_setting->where('group', $group_name)->where('param', $item->getName())->first();
				if(!empty($grab)){
					$item->setValue($grab->default_value);
				}
			}
		}
	}

	public function formattedOutput(){
		foreach($this->data as $group_name => $lists){
			foreach($lists['items'] as $item){
				$setting_key = strtolower($group_name.'.'.$item->getName());
				$setting_value = $item->getValue();
				if($item->getType() == 'image'){
					//harus diformat dulu sebelum output setting dapat diformat ke readable data
				}
				$this->formatted[$setting_key] = $setting_value;
			}
		}
		return $this->formatted;
	}

}