@extends ('core::layouts.master')
@section ('content')
	@include ('core::components.header-box')

	<form action="" method="post">
		{{ csrf_field() }}
		@if(isset($datatable))
			@if($datatable->mode  <> 'datatable')
				{!! $datatable->customTableView() !!}
			@else
				{!! $datatable->tableView() !!}
			@endif
		@endif
	</form>
@stop

@section ('datatable_script')
	@if(isset($datatable))
		@if($datatable->mode <> 'datatable')
			{!! $datatable->customAssets() !!}
		@else
			{!! $datatable->assets() !!}
		@endif
	@endif
@stop