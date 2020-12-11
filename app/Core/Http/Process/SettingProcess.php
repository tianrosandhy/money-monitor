<?php
namespace App\Core\Http\Process;

use App\Core\Http\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use Validator;
use Setting;

class SettingProcess extends BaseProcess
{
	public function config(){
		return [
			'error_redirect_target' => null, //ex : url('your-url-when-fail')
			'success_redirect_target' => null, //ex : url('your-url-when-success')
			'success_message' => 'Your setting has been saved successfully',
			'error_message' => 'Sorry we cannot save your setting right now'
		];
	}

	public function validate(){
	}

	public function process(){
		//your logic after validation success
		$lists = Setting::all();
		$savedata = [];
		$post = $this->request->all();
		foreach($lists as $key => $old_value){
			$split = explode('.', $key);
			if(count($split) <> 2){
				continue;
			}

			$from_input = $post[$split[0]][$split[1]] ?? null;
			if(strlen($from_input) > 0 && $from_input <> $old_value){
				$savedata[] = [
					'param' => $split[1],
					'group' => $split[0],
					'default_value' => $from_input
				];
			}
		}

		if(!empty($savedata)){
			//proses update setting value
			foreach($savedata as $saveindex => $row){
				$instance = app('setting')->where('param', $row['param'])->where('group', $row['group'])->first();
				if(!empty($instance)){
					$instance->default_value = $row['default_value'];
					$instance->save();
					unset($savedata[$saveindex]);
				}
			}
			//proses insert setting value
			if(!empty($savedata)){
				Setting::insert($savedata);
			}
		}
	}

	public function revert(){
		//your logic when validation or process failed to running
	}


}