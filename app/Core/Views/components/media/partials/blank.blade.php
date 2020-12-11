<div class="no-data text-center">
	<h3>No Image Data Found</h3>
	<img src="{{ admin_asset('images/not-found.png') }}" alt="Media data not found" style="max-height:200px;">
	<p>
		@if(isset($filtered))
			Oops, we cannot find image with that keyword.
		@else
			Oops, there is no image uploaded yet. 
		@endif
		You can start <a href="#" class="trigger-upload-tab">Upload Image</a> now</p>
</div>
