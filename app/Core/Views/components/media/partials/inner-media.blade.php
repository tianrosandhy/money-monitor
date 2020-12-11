<div class="media-image-container" style="min-height:400px; overflow-y:scroll;">
	@foreach($data as $row)
	<div class="cols">
		<a href="#" data-media-id="{{ $row->id }}" data-filename="{{ $row->filename }}" data-basename="{{ $row->basename }}" data-ext="{{ $row->extension }}" class="media-image-thumb" data-src="{{ $row->url('small') }}" data-origin="{{ $row->path }}">
			<img src="{{ $row->url('thumb') }}" alt="{{ $row->filename }}">
			<div>
				<small>{{ strlen($row->filename) > 15 ? substr($row->filename, 0, 12).'...' : $row->filename }}</small>
			</div>
		</a>
	</div>
	@endforeach
</div>
<div class="padd">
	{!! $data->links('core::components.media.partials.pagination') !!}
</div>
<div class="card-body filemanager-detail text-center">
	<div class="closer">
		<i class="icon" data-feather="x"></i>
	</div>
	<img class="holder-image" src="{{ Storage::url('2020/06/login-bg-thumb.jpg') }}" alt="Image Thumbnail" style="max-height:125px;">
	<h6 class="holder-title">Filename Example.jpg</h6>
	<div>
		<a class="holder-url" href="{{ Storage::url('2020/06/login-bg-small.jpg') }}" target="_blank">{{ Storage::url('2020/06/login-bg-small.jpg') }}</a>
	</div>
	<div>
		<div class="btn-group-vertical">
			<select data-id="" data-path="" data-thumb="" name="select_thumbnail" class="form-control filemanager-thumb-selection">
				<option value="origin">Original</option>
				@foreach(config('image.thumbs') as $tname => $tconfig)
				<option value="{{ $tname }}">{{ $tconfig['label'] }} ({{ $tconfig['width'] }} x {{ $tconfig['height'] }})</option>
				@endforeach
			</select>
			<a href="#" class="btn btn-primary btn-sm filemanager-select-final">Select This Image</a>
		</div>
		<div class="mt-3 text-center">
			<a href="#" class="text-danger delete-permanently"><i class="icon" data-feather="trash"></i> Delete Permanently</a>
		</div>
	</div>
</div>
