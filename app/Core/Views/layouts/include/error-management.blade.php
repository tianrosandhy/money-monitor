@if(isset($errors) || session('success') || session('error'))
@if($errors->any() || session('success') || session('error'))
<script>
toastr.options.timeOut = 10000;
$(function(){
	@foreach($errors->all() as $err)
		<?php
		$error = str_replace('.'.def_lang(), '', $err);
		?>
		toastr["error"]("{{ $error }}");
	@endforeach
	@if(session('success'))
		toastr["success"]("{{ session('success') }}");
	@endif
	@if(session('error'))
		@if(is_array(session('error')))
			@foreach(session('error') as $err)
				@if(is_array($err) && isset($err[0]))
				toastr["error"]("{{ $err[0] }}");
				@else
				toastr["error"]("{{ $err }}");
				@endif
			@endforeach
		@else
		toastr["error"]("{{ session('error') }}");
		@endif
	@endif
});
</script>
@endif
@endif