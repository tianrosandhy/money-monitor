<?php
namespace App\Core\Components;

use App\Core\Shared\DynamicProperty;

class Seo
{
	use DynamicProperty;

	public
		$base_title,
		$title,
		$description,
		$image,
		$keyword,
		$url;

	public function __construct(){
		$this->base_title = setting('seo.title', setting('general.title'));
		$this->description = setting('seo.description');
		$this->image = setting('seo.image');
	}

	public function generate(){
		return view('core::components.seo', [
			'title' => $this->title,
			'base_title' => $this->base_title,
			'description' => $this->description,
			'image' => $this->image,
			'keyword' => $this->keyword,
			'url' => $this->url
		])->render();
	}
}