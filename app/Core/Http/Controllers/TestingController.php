<?php
namespace App\Core\Http\Controllers;

use App\Core\Http\Controllers\BaseController;
use App\Core\Presenters\BaseViewPresenter;
use App\Core\Exceptions\MediaException;
use Media;

class TestingController extends BaseController
{
	// tests methods
	public function testFilemanager(){
		return view('core::test.media');
	}

	public function testFileManagerPost(){
		dd($this->request->all());
	}


}