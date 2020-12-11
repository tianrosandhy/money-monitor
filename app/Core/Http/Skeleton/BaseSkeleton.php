<?php
namespace App\Core\Http\Skeleton;

use App\Core\Components\DataTable\DataStructure;
use Validator;
use Language;

class BaseSkeleton
{
	use SkeletonHelper;

	public $structure = [];
	public $multi_language = false;
	public $mode = 'datatable';
	public $custom_html = null;

	public function __construct(){
		$this->request = request();
		if(method_exists($this, 'handle')){
			$this->handle();
		}
	}

	public function customFilter($context){
		return $context;
	}	

	public function generateValidation($mode='create', $id=null){
		$prefix = '';
		if($this->multi_language){
			$prefix = '.' . Language::default();
		}
		if(empty($id)){
			$id = 0;
		}

		$rule = [];
		$trans = [];
		$mode = strtolower($mode);
		foreach($this->output() as $row){
			if($row->getCreateValidation() && in_array($mode, ['store', 'insert', 'create'])){
				$rule[$row->getField().$prefix] = $row->getCreateValidation();
				$trans = array_merge($trans, $row->getValidationTranslation());
			}
			if($row->getUpdateValidation() && in_array($mode, ['update', 'edit'])){
				$rule[$row->getField().$prefix] = $row->getUpdateValidation();
				$trans = array_merge($trans, $row->getValidationTranslation());
			}
		}

		if($rule){
			//replace [id] menjadi id yg sesuai tabel yg bersangkutan
			$rule = array_map(function($item) use($id){
				return str_replace('[id]', $id, $item);
			}, $rule);

			return Validator::make(request()->all(), $rule, $trans);
		}
	}

	public function name(){
		$class_name = get_class($this);
		$split = explode('\\', $class_name);
		return $split[count($split)-1];
	}

	public function register(DataStructure $item){
		$this->structure[] = $item;
		return $this;
	}

	public function registers($arr=[]){
		foreach($arr as $item){
			if($item instanceof DataStructure){
				$this->structure[] = $item;
			}
		}
		return $this;
	}

	public function output(){
		return collect($this->structure);
	}



	// FOR DATATABLE HELPER METHODs
	public function route(){
		if(method_exists($this, 'dataTableRoute')){
			return $this->dataTableRoute();
		}
	}

	public function generateSearchQuery(){
		$out = '';
		$i = 0;
		foreach($this->output() as $row){
			if(!$row->getHideTable()){
				$fld = str_replace('[]', '', $row->getField());
				$out .= 'data.columns['.$i.']["search"]["value"] = $("[data-id=\'datatable-filter-'.$fld.'\']").val(), ';
				$i++;
			}
		}
		return $out;
	}
	
	public function generateJsonSearchQuery(){
		$out = [];
		$i = 0;
		$replacer = [];
		foreach($this->output() as $row){
			if(!$row->getHideTable()){
				$fld = str_replace('[]', '', $row->getField());
				$out['columns'][$i]['data'] = $fld;
				$out['columns'][$i]['search']['value'] = 'REPLACER-'.$i;
				$out['columns'][$i]['searchable'] = $row->searchable;
				$out['columns'][$i]['orderable'] = $row->orderable;

				if(in_array($row->getInputType(), ['date', 'daterange', 'datetime'])){
					//jika input type date / daterange / datetime, format replacer diganti menjadi array
					$replacer[$i] = '[ $("[data-id=\'datatable-filter-'.$fld.'\']").first().val(), $("[data-id=\'datatable-filter-'.$fld.'\']").last().val() ]';
				}
				else{
					$replacer[$i] = '$("[data-id=\'datatable-filter-'.$fld.'\']").val()';
				}
				$i++;
			}
		}
		$string = json_encode($out);
		for($x=0; $x<=$i; $x++){
			if(isset($replacer[$x])){
				$string = str_replace('"REPLACER-'.$x.'"', $replacer[$x], $string);
			}
		}
		return $string;
	}
	


	public function datatableOrderable(){
		$out = '';
		$i = 0;
		foreach($this->output() as $row){
			if($row->getHideTable() == false){
				if(!$row->getOrderable()){
					$out .= "{'targets' : ".$i.", 'orderable' : false}, ";
				}
				$i++;
			}
		}
		return $out;
	}

	public function datatableDefaultOrder(){
		$order_data = '[0,"desc"]'; //fallback
		$i = 0;
		foreach($this->output() as $row){
			if($row->getHideTable() == false){
				if($row->getDefaultOrder()){
					//kalau ada salah satu field yang set default order, langsung hentikan loop
					$order_data = '['.$i.', "'.$row->getDefaultOrder().'"]';
					break;
				}
				$i++;
			}
		}

		return $order_data;
	}

	public function datatableColumns(){
		$i = 0;
		$out = '';
		foreach($this->output() as $row){
			if($row->getHideTable() == false){
				$fld = str_replace('[]', '', $row->field);
				$out .= "{data : '".$fld."'}, ";
			}
		}
		$out .= "{data : 'action'}";
		return $out;
	}


}