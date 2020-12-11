<?php
if(!isset($hash)){
	$hash = sha1(md5(time() . rand(1, 10000000) . uniqid() ));
}
if(!isset($name)){
	$name = 'image';
}
?>
<input type="hidden" data-hash="{{ $hash }}" name="{{ $name }}" class="dropzone_uploaded listen_uploaded_file_multiple" value="{{ isset($value) ? $value : '' }}">
<div class="row">
	<div class="{{ isset($horizontal) ? 'col-sm-6' : 'col-sm-12' }}">
		<?php
		$max_size = (file_upload_max_size(config('cms.max_filesize.file')) / 1024 /1024);
		?>
		<div class="dropzone custom-dropzone dz-clickable filedropzone-multiple" data-hash="{{ $hash }}" upload-limit="{{ intval($max_size) }}" {!! isset($attr['accept']) ? 'accept="'.$attr['accept'].'"' : '' !!} data-target="{{ route('admin.post-document') }}"></div>
	</div>
	<div class="{{ isset($horizontal) ? 'col-sm-6' : 'col-sm-12' }}">
		<div class="uploaded-holder" data-hash="{{ $hash }}">
			@if(isset($value))
				<?php
				$trm = explode("|", $value);
				?>
				@foreach($trm as $val)
					<?php
					$parse = json_decode($val, true);
					?>
					@if($parse)
						<div class="uploaded">
							<a href="{{ $parse['path'] ?? '#' }}" download class="file-alias">{{ $parse['filename'] }}</a><span class="remove-asset-file-multiple" data-hash="{{ $hash }}" data-value="{{ $val }}">&times;</span>
						</div>
					@endif
				@endforeach
			@endif
		</div>		
	</div>
</div>
