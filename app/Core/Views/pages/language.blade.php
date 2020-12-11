@extends ('core::layouts.master')

@push ('style')
<style>
	.flag{
		display:inline-block;
		width:40px;
		height:40px;
		background-size:contain;
		background-repeat:no-repeat;
		background-position:center center;
	}
</style>
@endpush

@section ('content')

	@include ('core::components.header-box', [
		'control_buttons' => [
			[
				'url' => admin_url('/'),
				'label' => __('core::module.global.back_to_homepage'),
				'icon' => 'home'
			],
		]
	])

	<form action="" method="post">
		<div class="row">
			<div class="col-md-4">
				<div class="card mb-3">
					<div class="card-header bg-primary text-white">Default Language</div>
					<div class="card-body">
						<div class="pull-left float-left">	
							<span class="flag" style="background-image:url('{{ admin_asset('images/flag/' . strtoupper($default_language) . '.png') }}')"></span>					
						</div>
						<div class="pull-right float-right">
							<h4>{{ Language::name($default_language) }}</h4>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>

			</div>
			<div class="col-md-8">
				<div class="card mb-3">
					<div class="card-header bg-secondary text-white">Secondary Languages</div>
					<div class="card-body">
						@if($secondary_language)
						<ul class="list-group mb-5">
							@foreach($secondary_language as $code => $lang)
							<li class="list-group-item d-flex justify-content-between align-items-center">
								<span>{{ $lang }}</span>
								@if(Permission::has('admin.language.set-as-default'))
								<a href="{{ route('admin.language.set-as-default', ['id' => $code]) }}" class="badge badge-primary">Set as Default</a>
								@endif
								@if(Permission::has('admin.language.delete'))
								<a href="{{ route('admin.language.delete', ['id' => $code]) }}" class="badge badge-danger">Remove</a>
								@endif
							</li>
							@endforeach
						</ul>
						@else
						<div class="alert alert-warning">No secondary languages selected</div>
						@endif

						<p>You can add more secondary languages from these selection</p>
						<div class="form-group">
							<select name="languages[]" class="form-control select2" multiple>
								@foreach(Language::getLists() as $code => $name)
								<option value="{{ $code }}">{{ $name }}</option>
								@endforeach
							</select>
						</div>
						<div class="my-3">
							<button type="submit" class="btn btn-primary">
								<i data-feather="save"></i> Add Languages
							</button>
						</div>


					</div>
				</div>
			</div>
		</div>
	</form>
@stop