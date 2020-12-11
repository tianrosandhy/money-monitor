<?php
namespace App\Modules\Wallet\Http\Controllers;

use App\Core\Http\Controllers\BaseController;
use App\Modules\Wallet\Models\Wallet;
use App\Modules\Wallet\Presenters\WalletIndexPresenter;
use App\Modules\Wallet\Presenters\WalletCrudPresenter;
use App\Modules\Wallet\Http\Process\WalletDatatableProcess;
use App\Modules\Wallet\Http\Process\WalletCrudProcess;
use App\Modules\Wallet\Http\Process\WalletDeleteProcess;

class WalletController extends BaseController
{
	public function index(){
		return (new WalletIndexPresenter)->render();
	}

	public function datatable(){
		return (new WalletDatatableProcess)
			->type('datatable')
			->handle();
	}

	public function create(){
		$data = new Wallet;
		return (new WalletCrudPresenter($data))->render();
	}

	public function store(){
		return (new WalletCrudProcess(new Wallet))
			->type('http')
			->handle();
	}

	public function edit($id){
		$data = Wallet::findOrFail($id);
		return (new WalletCrudPresenter($data))->render();
	}

	public function update($id){
		$data = Wallet::findOrFail($id);
		return (new WalletCrudProcess($data))
			->type('http')
			->handle();
	}
	
	public function delete($id=null){
		return (new WalletDeleteProcess)
			->setModel(new Wallet)
			->setId($id)
			->type('ajax')
			->handle();
	}

}