<?php
namespace App\Core\Components;

use Language;
use App\Core\Models\SlugMaster as Model;

class SlugMaster
{

	public function insert($model, $slug_string=null){
		$table = $model->getTable();
		$pk = $model->getKey();
		$language = Language::default();

		$instance = Model::where('table', $table)->where('primary_key', $pk)->where('language', $language)->first();
		$slug = $this->slugForSaved($slug_string, $instance);

		if(empty($instance)){
			$instance = new Model;
			$instance->table = $table;
			$instance->primary_key = $pk;
			$instance->language = $language;
		}
		$instance->slug = $slug;
		$instance->save();

		return $instance;
	}

	protected function slugForSaved($slug, $except_instance=null){
		$slug = slugify($slug);
		$language = empty($language) ? def_lang() : $language;
		if($except_instance){
			$check = Model::where('slug', $slug)->where('id', '<>', $except_instance->id)->first();
		}
		else{
			$check = Model::where('slug', $slug)->first();
		}
		if(!empty($check)){
			//create slug iteration
			$grabs = Model::where('slug', 'like', $slug.'%')->orderBy('slug')->get(['slug']);
			$iteration = 1;
			foreach($grabs as $item){
				if($item->slug == $slug){
					continue;
				}
				$split = explode('-', $item->slug);
				$last_part = $split[count($split)-1];
				if(is_numeric($last_part)){
					$iteration = $last_part + 1;
				}
			}

			return $slug.'-'.$iteration;
		}
		return $slug;
	}

}