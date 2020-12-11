@if(isset($target))
<a href="{{ $target }}">
@endif
	<?php
	$src = setting('general.logo', admin_asset('images/logo.png'));
	?>
	<img src="{{ $src }}" alt="{{ isset($image_title) ? $image_title : 'Logo' }}" style="
		@if(isset($width))
		width:{{ $width }}px;
		@endif
		@if(isset($height))
		height:{{ $height }}px;
		@endif
	">
@if(isset($target))
</a>
@endif