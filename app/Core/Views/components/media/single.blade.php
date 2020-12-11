<?php
$hash = md5(sha1(rand(1, 100000) . uniqid() . time()));
$mode = $mode ?? 'vertical';
$value = $value ?? null;
$media = Media::getByJson($value);
?>
<div class="input-image-holder text-center" data-hash="{{ $hash }}">
	<input type="hidden" name="{{ $name }}" class="listen-image-upload" value="{{ $value ?? null }}">
	<div class="pull-left {{ $mode == 'vertical' ? 'float-left' : '' }}">
		<a href="#" class="trigger-upload-image">
			<img data-fallback="{{ admin_asset('images/broken-image.jpg') }}" src="{{ isset($media->id) ? $media->url('thumb') : $media->fallback() }}" alt="Image Uploader" class="avatar rounded-circle media-item">
		</a>
	</div>
	<div class="pull-right {{ $mode == 'vertical' ? 'float-left' : '' }} px-2">
		<a href="#" class="btn btn-sm btn-primary trigger-upload-image">Set Image</a>
		<div>
			<small>
			<a href="#" class="text-danger remove-image">Remove</a>
			</small>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
