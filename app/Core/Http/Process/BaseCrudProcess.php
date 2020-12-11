<?php
namespace App\Core\Http\Process;

use App\Core\Http\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use Validator;
use Language;
use SlugMaster;

class BaseCrudProcess extends BaseProcess
{
	public function __construct($instance=null){
		parent::__construct();
		if($instance){
			$this->mode = 'update';
		}
		else{
			$this->mode = 'create';
		}
		$this->instance = $instance;
		if(method_exists($this, 'setSkeleton')){
			$this->skeleton = $this->setSkeleton();
		}
		else{
			throw new ProcessException('Skeleton must be set in class that extend to BaseCrudProcess with "->setSkeleton()"');
		}
	}

	public function config(){
		return [
			'error_redirect_target' => null, //ex : url('your-url-when-fail')
			'success_redirect_target' => route('admin.page.index'), //ex : url('your-url-when-success')
			'success_message' => 'Your data has been saved successfully',
			'error_message' => null
		];
	}

	public function validate(){
		$validator = $this->skeleton->generateValidation($this->mode, $this->instance->getKey());
		if($validator){
			if($validator->fails()){
				throw new ProcessException($validator);
			}
		}
	}

	public function process(){
		//your logic after validation success
		if($this->skeleton->multi_language){
			$skeleton_inputs = $this->skeleton->autoCrudMultiLanguage();
		}
		else{
			$skeleton_inputs = $this->skeleton->autoCrud();
		}

		if(!empty($skeleton_inputs)){
			$inputs = $skeleton_inputs;
			if($this->skeleton->multi_language){
				$inputs = $skeleton_inputs[Language::default()] ?? $skeleton_inputs;
			}


			#DYNAMIC SINGLE MODE
			//create new instance if not exists, but use selected instance if exists
			$instance = $this->instance ?? $this->skeleton->model();
			if($instance instanceof \Illuminate\Database\Eloquent\Builder || $instance instanceof \Illuminate\Database\Query\Builder){
				$instance = $instance->getModel();
			}

			foreach($inputs as $field => $value){
				$instance->{$field} = $value;
			}
			$instance->save();

			#DYNAMIC MULTI LANGUAGE MODE
			if(method_exists($instance, 'translatorInstance')){
				#clear translate data setiap kali insert/update data
				$instance->clearTranslate();
				foreach(Language::available() as $lang => $langname){
					$trans = $instance->translatorInstance();
					$trans->lang = $lang;
					$inputs = $skeleton_inputs[$lang] ?? [];
					$added = 0;
					foreach($inputs as $field => $value){
						$trans->{$field} = $value;
						$added++;
					}
					//kalau gaada field yg ditambah, gausa save data translate
					if($added > 0){
						$trans->save();
					}
				}
			}

			if(method_exists($instance, 'slugTarget') && $this->request->slug_master){
				//store current slug master to 
				$slug_instance = SlugMaster::insert($instance, $this->request->slug_master);
			}

			if(method_exists($this, 'afterCrud')){
				$this->afterCrud($instance);
			}

		}

		// if you have another logic for storing data that doesnt cover by Skeleton, you can define them here.
	}

	public function revert(){
		//your logic when validation or process failed to running
	}


}