@extends ('core::layouts.master')

@section ('content')
@include ('core::components.header-box')
<div class="padd">
	@if(Permission::has('admin.log.export'))
	<form action="" class="card card-body">
		<div class="form-group custom-form-group">
			<label>Choose Log Filename</label>
			<select name="active_log" class="form-control select2" onchange="this.form.submit()">
				<option value="">- Choose Log Filename -</option>
				@foreach($available_log as $logs)
				<option value="{{ $logs }}" {{ $logs == $active_log ? 'selected' : '' }}>{{ $logs }}</option>
				@endforeach
			</select>
		</div>

		@if($active_log)
		<div class="panel">
			<div style="padding:1em 0">
				@if(isset($log_size))
				<strong>Log File Size : {{ $log_size }}</strong>
				@endif
				<a href="{{ url()->route('admin.log.export') }}?active_log={{ $active_log }}" class="btn btn-primary btn-block">Export Log</a>
			</div>
		</div>
		@endif
	</form>
	@else
	<div class="alert alert-warning">You doesn't have permission to export the stored log file</div>
	@endif
</div>

<div class="content-box card card-body">
	<h4>Error Reporting Service</h4>
	<?php
	$use_email_log = setting('log.active');
	?>
	@if($use_email_log)
		@if($stored_log->count() > 0)
		<div class="alert alert-info">Below are {{ $stored_log_count }} {{ $stored_log_count > $stored_log->count() ? '('.$stored_log->count().' latest data shown) ' : '' }} unreported exception in this site. You can <a href="{{ route('admin.log.mark-as-reported') }}" class="btn btn-secondary btn-sm">Mark All as Reported</a> if you dont want to receive the email error reporting notification for these records.</div>
		<div class="card card-body">
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>URL</th>
						<th>Type</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody>
					@foreach($stored_log as $row)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>
							<a href="{{ $row->url }}" target="_blank">{{ $row->url }}</a>
							<div>
								<small>{{ date('d M Y H:i:s', strtotime($row->created_at)) }}</small>
							</div>
						</td>
						<td>{{ $row->type ?? 'Undefined' }}</td>
						<td>
							{{ $row->description }}
							<div>
								@if(Permission::has('admin.log.detail'))
								<a href="{{ route('admin.log.detail', ['id' => $row->id]) }}" class="btn btn-sm btn-primary btn-show-log">Detail</a>
								@endif
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>			
		</div>
		@else
		<div class="alert alert-success">Yeay.. currently there are no unreported error log right now. We will show logs here if there are any error in this site.</div>
		@endif
	@else
	<div class="alert alert-warning">You are currently not using error reporting feature now. You can activate it in <a href="#" class="btn btn-sm btn-warning right-bar-toggle">Setting >> Log</a></div>
	@endif
</div>
@stop

@push ('modal')
<div class="modal fade fill-in" id="stacktrace-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body default-modal-content">

			</div>
		</div>
	</div>
</div>
@endpush

@push ('script')
<script>
$(function(){
	$(".btn-show-log").on('click', function(e){
		e.preventDefault();
		showLoading();
		$.ajax({
			url : $(this).attr('href'),
			dataType : 'html',
			success : function(resp){
				$("#stacktrace-modal .default-modal-content").html(resp);
				$("#stacktrace-modal").modal('show');
				hideLoading();
			},
			error : function(resp){
				hideLoading();
				swal('error', ['Sorry, we cannot open the log detail right now']);
			}
		});
	});
});
</script>
@endpush