<?php
$hash = md5(sha1(rand(1, 100000) . uniqid() . time()));
$value = $value ?? [];
if(!is_array($value)){
	$value = [$value];
}
?>
<div class="media-multiple-holder" container-hash="{{ $hash }}">
	<div class="multi-media-container">
		@foreach($value as $img)
		<?php
		$hash = md5(sha1(rand(1, 100000) . uniqid() . time()));
		$media = Media::getByJson($img);
		?>
		<div class="square-image input-image-holder text-center" data-hash="{{ $hash }}">
			<input type="hidden" name="{{ $name }}" class="listen-image-upload" value="{{ $img }}">
			<img data-fallback="{{ admin_asset('images/broken-image.jpg') }}" src="{{ isset($media->id) ? $media->url('thumb') : $media->fallback() }}" class="media-item">
			<a href="#" class="trigger-upload-image"></a>
			<div class="multi-closer">
				<i class="icon" data-feather="x"></i>
			</div>
		</div>
		@endforeach
	</div>
	<div class="square-image add">
		<div>
			<i class="icon" data-feather="plus"></i>
			<div>
				<small>Add Images</small>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<template id="media-multiple-single-item">
	<div class="square-image input-image-holder text-center" data-hash="CUSTOM_HASH">
		<input type="hidden" name="{{ $name }}" class="listen-image-upload">
		<img data-fallback="{{ admin_asset('images/broken-image.jpg') }}" src="{{ admin_asset('images/broken-image.jpg') }}" class="media-item">
		<a href="#" class="trigger-upload-image"></a>
		<div class="multi-closer remove-image">
			<i class="icon" data-feather="x"></i>
		</div>
	</div>
</template>