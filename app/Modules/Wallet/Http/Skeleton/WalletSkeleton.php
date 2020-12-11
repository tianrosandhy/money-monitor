<?php
namespace App\Modules\Wallet\Http\Skeleton;

use DataStructure;
use App\Core\Http\Skeleton\BaseSkeleton;
use App\Modules\Wallet\Models\Wallet;
use Permission;

class WalletSkeleton extends BaseSkeleton
{
	#ENABLE THIS PROPERTY IF YOU WANT TO USE MULTI LANGUAGE FEATURE
	//public $multi_language = true;

	#ENABLE THIS PROPERTY IF YOU DONT WANT TO USE THE NATIVE DATATABLE IN CRUD PAGE, AND YOU WANT TO DEFINE CUSTOM VIEW FOR EACH DATA ROW.
	//public $mode = 'custom'; // set ke mode custom untuk custom view menggantikan datatable
	//public $custom_html = 'wallet::custom-data';

	public function handle(){
		$this->registers([
			DataStructure::checker(),
			DataStructure::field('title')
				->name('Wallet Title')
				->inputType('text')
				->createValidation('required', true)
				->validationTranslation([
					'title.required' => 'Please fill the title'
				]),
			DataStructure::field('description')
				->name('Wallet Description')
				->hideTable()
				->inputType('textarea'),
			DataStructure::field('category')
				->name('Category')
				->inputType('select')
				->createValidation('required', true)
				->formColumn(4)
				->dataSource(config('module-setting.wallet.category')),
			DataStructure::field('wallet_type')
				->name('Wallet Type')
				->inputType('select')
				->createValidation('required', true)
				->formColumn(3)
				->dataSource([
					'credit' => 'Credit (+)',
					'debit' => 'Debit (-)',
				]),
			DataStructure::field('sort_no')
				->name('Sort No')
				->inputType('number')
				->searchable(false)
				->formColumn(3),
			DataStructure::switcher('is_active', 'Is Active')
				->formColumn(2)
				->valueData(function($data){
					if(strlen($data->is_active) == 0){
						return 1;
					}
					return $data->is_active ?? 0;
				}),
		]);
	}

	public function dataTableRoute(){
		return route('admin.wallet.datatable');
	}

	public function customFilter($context){
		// $searched_field = $this->getSearchField('field_name');
		return $context->where('user_id', $this->request->get('user')->id);
	}

	public function model(){
		return new Wallet;
	}

	public function rowFormat($row){
		return [
			'id' => $this->checkerFormat($row),
			'title' => $row->title,
			'description' => $row->description,
			'category' => ucwords($row->category),
			'wallet_type' => $row->wallet_type == 'credit' ? '<span class="badge badge-primary">Credit (+)</span>' : '<span class="badge badge-danger">Debit (-)</span>',
			'sort_no' => $row->sort_no,
			'is_active' => $this->switcherFormat($row, 'is_active', (Permission::has('admin.wallet.switch') ? 'toggle' : 'label')),
			'action' => $this->actionButton($row)
		];
	}

	protected function actionButton($row){
		$out = '';
		if(Permission::has('admin.wallet.edit')){
			$out .= '<a href="'.route('admin.wallet.edit', ['id' => $row->id]).'" class="btn btn-info">Edit</a>';
		}
		if(Permission::has('admin.wallet.delete')){
			$out .= '<a href="'.route('admin.wallet.delete', ['id' => $row->id]).'" class="btn btn-danger delete-button">Delete</a>';
		}
		return $out;
	}
}