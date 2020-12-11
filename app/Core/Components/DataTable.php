<?php
namespace App\Core\Components;

use App\Core\Http\Skeleton\BaseSkeleton;
use App\Core\Components\DataTable\DataTableProcessor;

class DataTable
{
	use DataTableProcessor;

	public 
		$skeleton,
		$request,
		$mode = 'datatable'; //mode : datatable & custom

	public function __construct(){
		$this->request = request();
	}

	public function setMode($mode){
		$this->mode = $mode;
		return $this;
	}

	public function setSkeleton(BaseSkeleton $skeleton){
		$this->skeleton = $skeleton;
		$this->mode = $this->skeleton->mode ?? 'datatable';
		return $this;
	}

	public function assets(){
		return view('core::components.datatable.asset', [
			'skeleton' => $this->skeleton
		]);
	}

	public function customAssets(){
		return view('core::components.datatable.custom-asset', [
			'skeleton' => $this->skeleton
		]);
	}

	public function tableView(){
		return view('core::components.datatable.table-view', [
			'skeleton' => $this->skeleton
		]);
	}

	public function customTableView(){
		return view('core::components.datatable.custom-table-view', [
			'skeleton' => $this->skeleton
		]);
	}



}