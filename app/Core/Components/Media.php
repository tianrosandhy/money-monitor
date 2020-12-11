<?php
namespace App\Core\Components;

use App\Core\Models\Media as Model;
use App\Core\Components\Media\MediaCacheManager;

class Media
{
	use Media\Uploader;
	use Media\MediaRequestProcessor;

	public function __construct(){
		$this->request = request();
	}

	public function getById($id){
		return (new MediaCacheManager)->getMediaCacheById($id);
	}

	public function getByJson($json){
		return (new MediaCacheManager)->getMediaCacheByJson($json);
	}

	public function getSelectedImage($json, $grabbed_thumb=null, $mode='url'){
		$instance = $this->getByJson($json);
		if(isset($instance->id)){
			$decode = json_decode($json, true);
			if(empty($grabbed_thumb)){
				$thumb = $decode['thumb'] ?? 'origin';
			}
			else{
				$thumb = $grabbed_thumb;
			}

			if($mode == 'url'){
				return $instance->url($thumb);
			}
			else{
				return $instance->path($thumb);
			}
		}
		return (new Model)->fallback();
	}



	public function assets(){
		return view('core::components.media.assets');
	}

	public function single($name, $value=null, $config=[]){
		return view('core::components.media.single', [
			'name' => $name,
			'value' => $value,
			'config' => $config
		]);
	}

	public function multiple($name, $value=null, $config=[]){
		return view('core::components.media.multiple', [
			'name' => $name,
			'value' => $value,
			'config' => $config
		]);
	}

}