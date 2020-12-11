@extends ('core::layouts.master')
@section ('content')

<h2>Media Manager Test</h2>

<div class="card card-body">
	<form action="" method="post">
		<div class="form-group">
			<label>Image Single</label>
			{!! Media::single('single', '{"thumb":"origin","id":"2","path":"2020/06/login-bg.jpg"}') !!}
		</div>
		
		<div class="form-group">
			<label>Image Multiple</label>
			{!! Media::multiple('image[]', null) !!}
		</div>
		

		<button type="submit" class="btn btn-primary">Test Submit</button>
	</form>
</div>
@stop