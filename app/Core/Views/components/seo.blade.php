<?php
if(strpos($image, 'http') === false){
	//if image is in json file, convert first
	$json_img = json_decode($image, true);
	if(isset($json_img['id'])){
		$image_path = Media::getSelectedImage($image, 'large', 'path');
	}
	else{
		$image_path = $image;
	}

	//image as path
	if(Storage::exists($image_path)){	
		try{
			list($image_width, $image_height) = getimagesize(Storage::path($image_path));
		}catch(\Exception $e){}
	}
	$image_url = Storage::url($image_path);
}
else{
	$image_url = $image;
}

$og_title = strlen($title) > 0 ? $title.' - '.$base_title : $base_title ;
?>
@if($description)
<meta name="description" content="{{ descriptionMaker($description, 30) }}">
@endif
@if($keyword)
<meta name="keywords" content="{{ $keyword }}">
@endif
@if(setting('seo.fb_app'))
<meta property="fb:app_id" content="{{ setting('seo.fb_app') }}">
@endif
<meta property="og:url" content="{{ $url ?? url()->current() }}">
<meta property="og:title" content="{{ $og_title }}">
@if(isset($image_url))
<meta property="og:image" itemprop="image" content="{{ $image_url }}">
@endif
@if(isset($image_width))
<meta property="og:image:width" content="{{ $image_width }}">
@endif
@if(isset($image_height))
<meta property="og:image:height" content="{{ $image_height }}">
@endif
@if($description)
<meta property="og:description" content="{{ descriptionMaker($description) }}">
@endif
<meta property="og:site_name" content="{{ $base_title }}">
<meta name="twitter:card" content="summary">
<meta name="twitter:url" content="{{ $url ?? url()->current() }}">
<meta name="twitter:title" content="{{ $og_title }}">
@if($description)
<meta name="twitter:description" content="{{ descriptionMaker($description, 25) }}">
@endif
@if(isset($image_url))
<meta name="twitter:image" content="{{ $image_url }}">
@endif