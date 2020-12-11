<?php
namespace App\Core\Shared;

use Str;

trait DynamicProperty
{
	// dynamic property setter & getter
	public function __call($name, $arguments){
		$method = substr($name, 0, 3);
		if(in_array($method, ['get', 'set'])){
			$prop = substr($name, 3);
			$prop = Str::snake($prop);

			if($method == 'get' && property_exists($this, $prop)){
				return $this->{$prop};
			}
			if($method == 'set' && isset($arguments[0])){
				$this->{$prop} = $arguments[0];
			}
			if($method == 'has'){
				$cond = isset($this->{$prop});
				if($cond){
					return !empty($cond);
				}
				return false;
			}
		}
		return $this;
	}

	public function with($array=[]){
		foreach($array as $key => $value){
			$this->{$key} = $value;
		}
		return $this;
	}

}