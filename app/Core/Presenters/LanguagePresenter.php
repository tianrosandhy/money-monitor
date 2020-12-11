<?php
namespace App\Core\Presenters;

use App\Core\Presenters\BaseViewPresenter;
use App\Core\Http\Skeleton\LanguageSkeleton;
use Language;

class LanguagePresenter extends BaseViewPresenter
{
	public function __construct(){
		$this->title = 'Language Setting';
		$this->default_language = Language::default();
		$this->secondary_language = Language::secondary();
		$this->view = 'core::pages.language';
	}

	public function setSelectedMenuName(){
		return 'language';
	}
}