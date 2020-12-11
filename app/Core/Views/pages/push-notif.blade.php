@extends ('core::layouts.master')
@section ('content')
    <section>
        <div class="notification-status">
            <span class="badge badge-secondary">Please Wait...</span>
        </div>
    </section>
    @include ('core::components.header-box')

    <p>All devices registered below can receive push notification from this CMS</p>

    @if(isset($datatable))
        {!! $datatable->tableView() !!}
    @endif

@stop

@section ('datatable_script')
	@if(isset($datatable))
		{!! $datatable->assets() !!}
	@endif
@stop