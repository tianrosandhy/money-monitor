<?php
namespace App\Core\Shared;

use Media;

trait ImageGrabable
{
	public function getImageUrl($field='image', $thumb=null){
		return Media::getSelectedImage($this->{$field}, $thumb, 'url');
	}

	public function getImagePath($field='image', $thumb=null){
		return Media::getSelectedImage($this->{$field}, $thumb, 'path');
	}

}