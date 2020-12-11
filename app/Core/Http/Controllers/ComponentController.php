<?php
namespace App\Core\Http\Controllers;

use App\Core\Http\Controllers\BaseController;
use App\Core\Presenters\BaseViewPresenter;
use App\Core\Exceptions\MediaException;
use App\Core\Components\GoogleAnalyticDashboard;
use Media;
use DB;
use Validator;
use Storage;
use Language;

class ComponentController extends BaseController
{

	public function postDocument(){
		$validate = self::validateInput();

		//kalo sudah oke, proses
		$file = $this->request->file('file');
		$filename = $file->getClientOriginalName();
		$extension = $file->getClientOriginalExtension();
		$nameonly = str_replace('.'.$extension, '', $filename);

		//check if file already exists
		$check_exists = Storage::exists('document'.'/'.$nameonly.'.'.$extension);
		if($check_exists){
			$stored_name = $nameonly.'-'.substr(sha1(rand(1, 10000)), 0, 10).'.'.$extension;
		}
		else{
			$stored_name = $nameonly.'.'.$extension;
		}

		$path = $this->request->file->storeAs('document', $stored_name);

		$data = [
			'url' => Storage::url(str_replace('\\', '/', $path)),
			'path' => str_replace('\\', '/', $path),
			'filename' => $stored_name,
		];

		return $data;		
	}

	protected function validateInput(){
		$validate = Validator::make($this->request->all(), [
			'file' => 'file|max:'.(file_upload_max_size(config('cms.max_filesize.file')) / 1024)
		], [
			'file.file' => 'Please upload the file',
			'file.max' => 'File document is too large',
		])->validate();
	}



	public function deleteDocument(){
		$validate = Validator::make($this->request->all(), [
			'data' => 'required'
		])->validate();

		$data = json_decode($this->request->data, true);
		if(isset($data['path'])){
			//remove image dan file punya action yg ga jauh berbeda
			if(Storage::exists($data['path'])){
				Storage::delete($data['path']);				
			}
		}

		return [
			'type' => 'success', 
			'message' => 'File '.$data['filename'].' has been deleted'
		];
	}








	public function mediaUpload(){
		try{
			$uploader = Media::upload($this->request->file);
		}catch(MediaException $e){
			return response()->json([
				'type' => 'error',
				'message' => $e->getMessage()
			], 403);
		}

		return response()->json([
			'type' => 'success',
			'message' => $uploader->id
		]);
	}

	public function filemanager(){
		$data = Media::getByRequest();
		if($data->count() == 0){
			if($this->request->keyword){
				return view('core::components.media.partials.blank', ['filtered' => true]);
			}
			return view('core::components.media.partials.blank');
		}

		return view('core::components.media.partials.inner-media', compact(
			'data'
		));
	}

	public function getImageUrl(){
		$this->request->validate([
			'id' => 'required',
			'thumb' => 'required'
		]);

		$img_instance = Media::getById($this->request->id);
		if($img_instance){
			$img_url = $img_instance->url($this->request->thumb);
			return '<img src="'.$img_url.'" class="media-image">';
		}
	}


	public function removeMedia($id){
		Media::removeById($id);
		return response()->json([
			'type' => 'success',
			'message' => 'Image has been removed'
		]);
	}


	public function switcherMaster(){
		$this->request->validate([
			'id' => 'required',
			'pk' => 'required',
			'table' => 'required',
			'field' => 'required'
		]);

		try{
			$table = decrypt($this->request->table);
			$pk = decrypt($this->request->pk);
			$id = decrypt($this->request->id);
			$field = decrypt($this->request->field);
			$tb = DB::table($table)->where($pk, $id)->update([
				$field => intval($this->request->value) 
			]);
			return response()->json([
				'type' => 'success'
			]);
		}catch(\Exception $e){
			return abort(403);
		}

	}





	public function analyticDashboardReport(){
		$datediff = 30; //normalnya analytic dalam date range bulanan
		$period_string = 'this week';
		if(is_array($this->request->period)){
			//must be an array with date values
			if(count($this->request->period) <> 2){
				return '<div class="alert alert-danger">Invalid date format</div>';
			}
			if(!strtotime($this->request->period[0]) || !strtotime($this->request->period[1])){
				return '<div class="alert alert-danger">Invalid date format inputted</div>';
			}

			if(strtotime($this->request->period[0]) > strtotime($this->request->period[1])){
				return '<div class="alert alert-danger">Invalid date range. Please input the right start and end date</div>';
			}

			$datediff = (strtotime($this->request->period[1]) - strtotime($this->request->period[0])) / 86400;
			$period_string = date('d M Y', strtotime($this->request->period[0])) . ' - ' . date('d M Y', strtotime($this->request->period[1]));
		}
		$analytic = new GoogleAnalyticDashboard($this->request->all());

		return view('core::components.analytic.dashboard-inner', compact(
			'analytic',
			'datediff',
			'period_string'
		));		
	}



	public function switchLang(){
		$available_lang = Language::available();
		if($this->request->lang){
			if(isset($available_lang[$this->request->lang])){
				session(['lang' => $this->request->lang]);
			}
		}
		return redirect()->back();
	}
}