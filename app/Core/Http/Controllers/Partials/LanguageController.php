<?php
namespace App\Core\Http\Controllers\Partials;

use App\Core\Presenters\LanguagePresenter;
use App\Core\Http\Process\LanguageDatatableProcess;
use Language as Helper;

trait LanguageController
{
	public function language(){
		return (new LanguagePresenter)->render();
	}

	public function addLanguage(){
		if(is_array($this->request->languages)){
			foreach($this->request->languages as $lang){
				Helper::setAsSecondary($lang);
			}
		}
		return redirect()->route('admin.language.index')->with('success', 'Secondary languages has been updated');
	}

	public function setAsDefaultLanguage($code){
		Helper::setAsDefault($code);
		return redirect()->route('admin.language.index')->with('success', 'Default language has been changed');
	}

	public function removeLanguage($code){
		Helper::remove($code);
		return redirect()->route('admin.language.index')->with('success', 'Default language has been deleted');
	}

}