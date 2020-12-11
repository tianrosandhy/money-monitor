<?php
namespace App\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
	public $table = 'medias';

	public function url($thumb='origin'){
		return $this->urlList()[$thumb] ?? $this->fallback();
	}

	public function path($thumb='origin'){
		return $this->pathList()[$thumb] ?? false;
	}

	public function fallback(){
		return admin_asset('images/broken-image.jpg');
	}

	public function urlList(){
		$data = $this->pathList();
		return array_map(function($item){
			return \Storage::url($item);
		}, $data);
	}

	public function pathList(){
		$lists = config('image.thumbs');
		$out = [];

		$path_only = str_replace($this->filename, '', $this->path);
		$out['origin'] = $this->path;
		if(config('image.enable_webp')){
			$out['origin-webp'] = str_replace($this->extension, 'webp', $this->path);
		}

		foreach($lists as $thumbname => $thumbdata){
			$out[$thumbname] = $path_only . $this->basename.'-'.$thumbname.'.'.$this->extension;
			if(config('image.enable_webp')){
				$out[$thumbname.'-webp'] = $path_only . $this->basename.'-'.$thumbname.'.webp';
			}
		}
		return $out;
	}
}
