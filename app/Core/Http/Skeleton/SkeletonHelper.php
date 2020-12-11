<?php
namespace App\Core\Http\Skeleton;

use App\Core\Exceptions\SkeletonException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Language;

trait SkeletonHelper
{
	public function getSkeletonName(){
		$class_name = (string)get_class($this);
		$split = explode("\\", $class_name);
		return $split[count($split)-1];
	}

	//utk generate checker datatable
	public function checkerFormat($row, $primary_key='id'){
		return '<input type="checkbox" data-id="'.$row->{$primary_key}.'" name="multi_check['.$row->{$primary_key}.']" class="multichecker_datatable"><span style="color:transparent; position:absolute;">'.$row->{$primary_key}.'</span>';		
	}

	public function switcherFormat($row, $field='is_active', $mode='toggle'){
		if($mode == 'toggle'){
			$table = $row->getTable();
			return view('core::components.input.yesno', [
				'value' => $row->{$field},
				'name' => $field,
				'attr' => [
					'data-id' => encrypt($row->getKey()),
					'data-pk' => encrypt($row->getKeyName()),
					'table' => encrypt($table),
					'field' => encrypt($field),
					'data-table-switch' => 1
				]
			])->render();
		}
		else{
			return $row->{$field} ? '<span class="badge badge-success" title="Active"><i data-feather="check"></i></span>' : '<span class="badge badge-danger" title="Not Active"><i data-feather="x"></i></span>';
		}
	}

	public function getSearchField($field_name){
		$columns = $this->request->columns ?? [];
		foreach($columns as $item){
			$field = $item['data'] ?? null;
			$value = $item['search']['value'] ?? null;
			if(strtolower($field) == strtolower($field_name)){
				return $value;
			}
		}
		return null;
	}









	public function modelTableListing(){
		$model = $this->model();
		if($model instanceof Model || $model instanceof Builder){
			if($model instanceof Builder){
				$model = $model->getModel();
			}
			return $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
		}
		throw new SkeletonException('You need to define the model skeleton first');
	}

	public function getTableName(){
		$model = $this->model();
		if($model instanceof Model || $model instanceof Builder){
			if($model instanceof Builder){
				$model = $model->getModel();
			}
			return $model->getTable();
		}
		throw new SkeletonException('You need to define the model skeleton first');
	}

	// generate auto CRUD prepared data by skeleton's data
	public function autoCrud($lang=null){
		$table_listing = $this->modelTableListing();
		$table_name = $this->getTableName();

		if(empty($lang)){
			$lang = Language::default();
		}

		$post = [];
		foreach($this->output() as $row){
			if(!$row->getHideForm()){
				if(in_array($row->getField(), $table_listing)){
					$value_for_saved = $this->request->{$row->getField()} ?? null;
					if($this->multi_language){
						$fallback = $value_for_saved[Language::default()] ?? null;
						$value_for_saved = $value_for_saved[$lang] ?? $fallback;
					}
					if($row->input_type == 'currency'){
						$value_for_saved = str_replace('.', '', $value_for_saved);
						$value_for_saved = str_replace(',', '.', $value_for_saved);	
					}

					if($row->input_type == 'map'){
						$value_for_saved = !empty($value_for_saved) ? json_encode($value_for_saved) : null;
					}

					//we cannot save the array value to database
					if(is_array($value_for_saved)){
						$value_for_saved = null;
					}
					//set fallback non existent string as null
					if(strlen($value_for_saved) == 0){
						$value_for_saved = null;
					}
					$post[$row->getField()] = $value_for_saved;
				}
			}
		}
		return $post;
	}

	public function autoCrudMultiLanguage(){
		$out = [];
		foreach(Language::available() as $lang => $langname){
			$out[$lang] = $this->autoCrud($lang);
		}
		return $out;
	}

}