<?php
namespace App\Core\Http\Process;

use App\Core\Http\Process\BaseCrudProcess;
use App\Core\Http\Skeleton\PushNotifSkeleton;

class PushNotifCrudProcess extends BaseCrudProcess
{
	public function setSkeleton(){
		return new PushNotifSkeleton;
	}

	public function config(){
		return [
			'error_redirect_target' => null, //ex : url('your-url-when-fail')
			'success_redirect_target' => route('admin.push-notif.index'), //ex : url('your-url-when-success')
			'success_message' => 'Your data has been saved successfully',
			'error_message' => null
		];
	}

}