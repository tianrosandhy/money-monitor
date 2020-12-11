<?php
namespace App\Core\Http\Controllers\Partials;

use App\Core\Presenters\PushNotifPresenter;
use App\Core\Presenters\PushNotifCrudPresenter;
use App\Core\Models\UserPushToken;
use App\Core\Http\Skeleton\PushNotifSkeleton;
use App\Core\Http\Process\BaseDatatableProcess;
use App\Core\Http\Process\BaseDeleteProcess;
use App\Core\Http\Process\PushNotifCrudProcess;

trait PushNotifController
{
	public function pushNotif(){
		return (new PushNotifPresenter)->render();
	}

    public function storePushNotif(){
        if($this->request->pushtoken){
            $current_user = $this->request->get('user');
            $get = UserPushToken::where('push_token', $this->request->pushtoken)->first();
            if(empty($get)){
                //simpan push token
                $up = new UserPushToken;
                $up->user_id = $current_user->id;
                $up->device_name = substr($this->request->device_name, 0, 190);
                $up->push_token = $this->request->pushtoken;
                $up->is_active = 1;
                $up->save();

                return response()->json([
                    'type' => 'success'
                ]);
            }
			else if($get->is_active == 0){
				//update the inactive pushtoken
				$get->is_active = 1;
				$get->save();
			}
        }
    }

    public function pushNotifManagementDataTable(){
		return (new BaseDatatableProcess)
			->setSkeleton(new PushNotifSkeleton)
			->type('datatable')
			->handle();
    }

	public function pushNotifCreate(){
		$pushtoken = new UserPushToken;
		return (new PushNotifCrudPresenter($pushtoken))->render();
	}

	public function pushNotifStore(){
		return (new PushNotifCrudProcess())
			->type('http')
			->handle();
	}

	public function pushNotifEdit($id){
		$pushtoken = UserPushToken::findOrFail($id);
		return (new PushNotifCrudPresenter($pushtoken))->render();
	}

	public function pushNotifUpdate($id){
		$data = UserPushToken::findOrFail($id);
		return (new PushNotifCrudProcess($data))
			->type('http')
			->handle();
	}

	public function pushNotifDelete($id){
		return (new BaseDeleteProcess)
			->setModel(new UserPushToken)
			->setId($id)
			->type('ajax')
			->handle();
	}
}