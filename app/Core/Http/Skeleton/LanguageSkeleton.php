<?php
namespace App\Core\Http\Skeleton;

use DataStructure;
use App\Core\Http\Skeleton\BaseSkeleton;
use App\Core\Models\Language;

class LanguageSkeleton extends BaseSkeleton
{
	public function handle(){
		$this->registers([
			DataStructure::checker(),
			DataStructure::field('code')
				->name('Language')
				->inputType('select')
				->dataSource([
					'en' => 'English',
					'id' => 'Indonesia'
				]),
			DataStructure::switcher('is_default_language', 'Is Default Language')
		]);
	}

	public function dataTableRoute(){
		return route('admin.language.datatable');
	}

	public function model(){
		return new Language;
	}

	public function rowFormat($row){
		return [
			'id' => $this->checkerFormat($row),
			'code' => $row->code,
			'is_default_language' => $row->is_default_language ?? 0,
			'action' => $this->actionButton($row)
		];
	}

	protected function actionButton($row){
		return '
		<a href="#" class="btn btn-primary">Detail</a>
		<a href="#" class="btn btn-info">Edit</a>
		<a href="#" class="btn btn-danger">Delete</a>
		';
	}
}