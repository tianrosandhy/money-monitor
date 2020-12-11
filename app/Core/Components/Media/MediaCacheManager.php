<?php
namespace App\Core\Components\Media;

use Cache;
use App\Core\Models\Media;

class MediaCacheManager
{
	public $cache_prefix = 'MEDIA';

	public function __construct(){

	}

	public function createMediaCache($instance){
		Cache::put($this->getCacheId($instance->id), $instance);
	}

	public function buildAllMediaCache(){
		$data = Media::get();
		foreach($data as $row){
			$this->createMediaCache($row);
		}
	}

	public function getMediaCacheById($id){
		$cache = Cache::get($this->getCacheId($id));
		if(empty($cache)){
			$instance = Media::find($id);
			if($instance){
				$this->createMediaCache($instance);
			}
			else{
				$instance = new Media;
			}
			return $instance;
		}
		return $cache;

	}

	public function getMediaCacheByJson($json){
		$data = json_decode($json, true);
		if(isset($data['id'])){
			return $this->getMediaCacheById($data['id']);
		}

		//fallback : return blank instance
		$instance = new Media;
		return $instance;
	}

	protected function getCacheId($instance_id){
		return $this->cache_prefix.'-'.$instance_id;
	}
}